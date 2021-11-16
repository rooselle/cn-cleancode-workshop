<?php

class Page
{
    public const NEOPASS_FORM_POSTE_1 = 'FORM_POSTE_1';
    public const NEOPASS_FORM_POSTE_2 = 'FORM_POSTE_2';
    public const NEOPASS_FORM_POSTE_3 = 'FORM_POSTE_3';
    public const NEOPASS_FORM_POSTE_4 = 'FORM_POSTE_4';
    public const NEOPASS_FORM_POSTE_5 = 'FORM_POSTE_5';
    public const PAGES_COMPETENCES_PERSO = 'COMPETENCES_PERSO';
    public const PAGES_COMPETENCES_SOCIO_PRO = 'COMPETENCES_SOCIO_PRO';

    public int $id;
    public string $name;
    public string $libelle;

    public static function findByName(string $name): PageCollection
    {
        return new PageCollection();
    }

    /**
     * @return array<Page>
     */
    public static function listPagesByName(string $name): array
    {
        return [];
    }
}
