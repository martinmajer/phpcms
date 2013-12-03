<?php

class Page extends Model implements Content {

    const TABLE = "page";
    
    
    /** Adresa stránky. */
    public $slug;
    
    /** Titulek stránky. */
    public $title;
    
    /** Text. */
    public $text;
    
    /** Jméno šablony. */
    public $template;
    
    /** Meta tag description. */
    public $meta;
    
    /** Dodatečné parametry. */
    public $params;
    
    
    public function load($rawData) {
        $this->slug = $rawData['slug'];
        $this->title = $rawData['title'];
        $this->text = $rawData['text'];
        $this->template = $rawData['template'];
        $this->meta = $rawData['meta'];
        $this->params = @unserialize($rawData['params']);
    }
    
    public function saveNew() {
        $helper = new SqlHelper(Page::TABLE);
        $this->id = $helper->insert(array(
            'slug!' => $this->slug,
            'title!' => $this->title,
            'text!' => $this->text,
            'template!' => $this->template,
            'meta!' => $this->meta,
            'params!' => serialize($this->params)
        ));
        return $this->id;
    }

    public function update() {
        $helper = new SqlHelper(Page::TABLE);
        return $helper->update(array(
            'slug!' => $this->slug,
            'title!' => $this->title,
            'text!' => $this->text,
            'template!' => $this->template,
            'meta!' => $this->meta,
            'params!' => serialize($this->params)
        ), $helper->idWhere($this->id));
    }
    
    public function delete() {
        $helper = new SqlHelper(Page::TABLE);
        return $helper->delete($helper->idWhere($this->id));
    }

    /** Vykreslí stránku. */
    public function render() {
        $tplLoader = new TemplateLoader();
        $template = $tplLoader->getTemplate($this->template);
        if (!$template) header_500();
        
        $template->setParam("title", $this->title);
        $template->setParam("text", $this->text);
        $template->setParam("slug", $this->slug);
        
        $template->setParams($this->params);
        
        $template->render();
    }

    public function getTitle() {
        return $this->slug != "/" ? $this->title : "";
    }

    public function getMeta() {
        return $this->meta;
    }
    
}

class PageFactory extends ModelFactory {
    
    /**
     * Vrátí stránku podle slugu.
     * @return Page
     */
    public function getBySlug($slug) {
        $pages = $this->loadCollection("slug = '" . db()->escape_string($slug) . "'");
        if (!$pages) return null;
        else return current($pages);
    }
    
    /**
     * Načte stránky.
     * @param type $where
     * @param type $order
     * @param type $offset
     * @param type $count
     * @return Page[]
     */
    public function loadCollection($where = null, $order = null, $offset = null, $count = null) {
        $helper = new ModelFactoryHelper($this, Page::TABLE);
        return $helper->simpleLoadCollection($where, $order, $offset, $count);
    }

    /**
     * Načte jednu stránku podle ID.
     * @param type $id
     * @return Page
     */
    public function loadSingle($id) {
        $helper = new ModelFactoryHelper($this, Page::TABLE);
        return $helper->simpleLoadSingle($id);
    }

    /**
     * Vytvoří novou prázdnou stránku.
     * @return Page
     */
    public function makeNew() {
        return new Page();
    }

    public function getCount($where = null) {
        $helper = new ModelFactoryHelper($this, Page::TABLE);
        return $helper->simpleGetCount($where);
    }
    
}