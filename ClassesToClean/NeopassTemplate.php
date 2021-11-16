<?php

class NeopassTemplate {
    public string $type;
    public Collection $versions;
    public Page $page;

    public function handle()
    {
        $content = config('neopass.page-template.content.'.$this->type);

        switch($this->type){
            case PageTemplate::TYPE_REF_MULTI_1:
            case PageTemplate::TYPE_REF_MULTI_2:
            case PageTemplate::TYPE_REF_MULTI_3:
                $name = (count($this->versions)>0) ? $this->page->libelle.' V'.(count($this->versions)+1) : $this->page->libelle;
                return $this->createPageTemplate($name, $content);
                break;
            case PageTemplate::TYPE_REF_PRO:
                $filteredVersions = array_filter($this->versions->all(), function($v){
                    return $this->versions[$v]->page_template_id === 0;
                }, ARRAY_FILTER_USE_KEY);

                $name = (count($filteredVersions)>0) ? 'Grille d\'évaluation -V'.(count($filteredVersions)+1) : 'Grille d\'évaluation -V1';

                $pageTemplate = null;
                $pages = [Page::NEOPASS_FORM_POSTE_1, Page::NEOPASS_FORM_POSTE_2, Page::NEOPASS_FORM_POSTE_3, Page::NEOPASS_FORM_POSTE_4, Page::NEOPASS_FORM_POSTE_5];
                foreach ($pages as $page){
                    $this->page = Page::findByName($page)->first();
                    $createdPageTemplate = $this->createPageTemplate($name, $content, $pageTemplate);
                    if($page == 'p1'){
                        $pageTemplate = $createdPageTemplate;
                    }
                }
                return $createdPageTemplate;
                break;
            case PageTemplate::TYPE_JOB_DESC:
            case PageTemplate::TYPE_REF_FORMATION:
                $name = $this->page->libelle;
                return $this->createPageTemplate($name, $content);
                break;
        }
    }

    public function __invoke(Int $id, String $page)
    {
        if (Auth::user()->isSuperAdmin()){
            return 'TODO'; //TODO return all users with their data
        }

        switch ($page){
            case 'competencesperso':
                $pages = Page::listPagesByName(Page::PAGES_COMPETENCES_PERSO);
                break;
            case 'competencessociopro':
                $pages = Page::listPagesByName(Page::PAGES_COMPETENCES_SOCIO_PRO);
                break;
        }


        $page_name_id = [];
        foreach ($pages as $page) {
            $page_name_id[$page->name] = $page->id;
        }


        if (Auth::user()->isReferentOrGreater() && Auth::user()->can('neopass')){
            $datas = [];
            /* Extract all neopass datas */
            foreach($page_name_id as $name => $id_page){
                if(User::find($id)->hasData()){
                    foreach(User::find($id)->data as $data){
                        if($data->page_id == $id_page){
                            $datas[$name][] = $data->data;
                        }
                    }
                }else{
                    $datas[] = null;
                }
            }
            return $datas;
        }else{
            return -1;
        }
    }

    private function createPageTemplate(string $name, array $content, ?PageTemplate $template = null): PageTemplate
    {
        // this method is only for demonstration purpose

        return new PageTemplate();
    }
}
