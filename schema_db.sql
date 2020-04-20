-- Adminer 4.7.1 SQLite 3 dump

DROP TABLE IF EXISTS "courses_achats";
CREATE TABLE "courses_achats" (
  "liste_id" integer NOT NULL,
  "produit_id" integer NOT NULL,
  "achat_quantite" numeric NOT NULL,
  "unite_id" integer NULL,
  "achat_date_creation" text NOT NULL,
  "achat_date_suppression" integer NULL,
  FOREIGN KEY ("unite_id") REFERENCES "referentiel_unites" ("unite_id") ON DELETE NO ACTION ON UPDATE NO ACTION,
  FOREIGN KEY ("produit_id") REFERENCES "produits_produit" ("produit_id") ON DELETE NO ACTION ON UPDATE NO ACTION,
  FOREIGN KEY ("liste_id") REFERENCES "courses_listes" ("liste_id") ON DELETE NO ACTION ON UPDATE NO ACTION
);


DROP TABLE IF EXISTS "courses_listes";
CREATE TABLE "courses_listes" (
  "liste_id" integer NOT NULL PRIMARY KEY AUTOINCREMENT,
  "liste_nom" text NOT NULL,
  "liste_date_creation" text NOT NULL,
  "liste_date_suppression" text NULL
);


DROP TABLE IF EXISTS "courses_recettes";
CREATE TABLE "courses_recettes" (
  "liste_id" integer NOT NULL,
  "recette_id" integer NOT NULL,
  "recette_date_creation" text NOT NULL,
  "recette_date_suppression" integer NULL,
  FOREIGN KEY ("liste_id") REFERENCES "courses_listes" ("liste_id"),
  FOREIGN KEY ("recette_id") REFERENCES "recettes_recette" ("recette_id")
);


DROP TABLE IF EXISTS "produits_produit";
CREATE TABLE "produits_produit" (
  "produit_id" integer NOT NULL PRIMARY KEY AUTOINCREMENT,
  "rayon_id" integer NOT NULL,
  "produit_nom" text NOT NULL,
  "produit_date_creation" text NOT NULL,
  "produit_date_suppression" text NULL,
  FOREIGN KEY ("rayon_id") REFERENCES "rayons_rayon" ("rayon_id") ON DELETE NO ACTION ON UPDATE NO ACTION,
  FOREIGN KEY ("rayon_id") REFERENCES "rayons_rayon" ("rayon_id") ON DELETE NO ACTION ON UPDATE NO ACTION
);


DROP TABLE IF EXISTS "rayons_rayon";
CREATE TABLE "rayons_rayon" (
  "rayon_id" integer NOT NULL PRIMARY KEY AUTOINCREMENT,
  "rayon_nom" text NOT NULL,
  "rayon_date_creation" text NULL,
  "rayon_date_suppression" text NULL
);


DROP TABLE IF EXISTS "recettes_ingredients";
CREATE TABLE "recettes_ingredients" (
  "recette_id" integer NOT NULL,
  "produit_id" integer NOT NULL,
  "unite_id" integer NULL,
  "ingredient_quantite" numeric NULL,
  "ingredient_date_creation" text NOT NULL,
  "ingredient_date_suppression" text NULL,
  FOREIGN KEY ("unite_id") REFERENCES "referentiel_unites" ("unite_id") ON DELETE NO ACTION ON UPDATE NO ACTION,
  FOREIGN KEY ("produit_id") REFERENCES "produits_produit" ("produit_id") ON DELETE NO ACTION ON UPDATE NO ACTION,
  FOREIGN KEY ("recette_id") REFERENCES "recettes_recette" ("recette_id") ON DELETE NO ACTION ON UPDATE NO ACTION
);


DROP TABLE IF EXISTS "recettes_recette";
CREATE TABLE "recettes_recette" (
  "recette_id" integer NOT NULL PRIMARY KEY AUTOINCREMENT,
  "recette_nom" text NOT NULL,
  "recette_instructions" text NOT NULL,
  "recette_date_creation" text NOT NULL,
  "recette_date_suppression" text NULL
);


DROP TABLE IF EXISTS "referentiel_unites";
CREATE TABLE "referentiel_unites" (
  "unite_id" integer NOT NULL PRIMARY KEY AUTOINCREMENT,
  "unite_nom" text(55) NOT NULL,
  "unite_date_creation" text NOT NULL,
  "unite_date_suppression" text NULL
);
