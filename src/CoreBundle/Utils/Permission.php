<?php

namespace CoreBundle\Utils;

/**
 * 
 */
trait Permission
{
    public static $_accessDossier = 'ACCESS_DOSSIER';
    public static $_addDossier = 'ADD_DOSSIER';
    public static $_deleteDossier = 'DELETE_DOSSIER';
    public static $_updateDossier = 'UPDATE_DOSSIER';
    public static $_accessDial = 'ACCESS_MESSAGERIE';

    public static $_permissions = array(
        "Accès Marché" => 'ACCESS_MARKET',
        "Accès Ecole" => 'ACCESS_SCHOOL',
        "Gérer Marché" => 'MANAGE_MARKET',
        "Gérer Bibliothèque" => 'MANAGE_LIBRARY',
        "Gérer Scolarité" => 'MANAGE_SCOLARSHIP',
        "Accès Ressource Humaine" => 'ACCESS_RH',
        "Accès Comptabilité Matière" => 'ACCESS_CM',
        "Accès à la liste des employés" => 'ACCESS_CARRIERE',
        "Ajouter un contrat" => 'ADD_CONTRAT',
        "Ajouter un employé" => 'ADD_USER',
        "Ajouter une sanction" => 'ADD_SANCTION',
        "Ajouter un congé" => 'ADD_CONGE',
        "Echelonner un employé" => 'ADD_ECHELON',
        "Supprimer un employé" => 'DELETE_USER',
        "Modifier un employé" => 'UPDATE_USER',
        "Accès aux dossiers" => 'ACCESS_DOSSIER',
        "Ajouter un dossier" => 'ADD_DOSSIER',
        "Supprimer un dossier" => 'DELETE_DOSSIER',
        "Modifier un dossier" => 'UPDATE_DOSSIER',
        "Accès au solde" => 'ACCESS_SOLDE',
        "Accès à la messagerie" => 'ACCESS_MESSAGERIE',
        "Accès aux paramètres" => 'ACCESS_SETTING',
        "Modifier les paramètres" => 'UPDATE_SETTING',
        "Ajouter Mission" => 'ADD_MISSION',
        "Ajouter Pénalité" => 'ADD_PENALITE',
        );

    
    abstract public function getPermissions();

    public function isPermitTo($permission) {
        $permissions = $this->getPermissions();

        foreach ($permissions as $key => $value) {
            if($value == $permission)
                return true;
        }

        return false;
    }
}
