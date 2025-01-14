set schema 'sae_db';

TRUNCATE TABLE
_activite,
_activite_prestation,
_adresse,
_avis,
_avis_restauration_note,
_compte,
_facture,
_horaire,
_langue,
_log_changement_status,
_membre,
_offre,
_parc_attraction,
_prestation,
_pro_prive,
_pro_public,
_professionnel,
_restaurant_type_repas,
_restauration,
_rib,
_souscription,
_spectacle,
_tag,
_tag_offre,
_tag_restaurant,
_tag_restaurant_restauration,
_type_repas,
_visite,
_visite_langue
RESTART IDENTITY CASCADE;

-- Vider le dossier public/images/offres/