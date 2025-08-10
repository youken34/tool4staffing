### Problèmes potentiels et solutions

1. **Manipulation d'identité client**

   - Problème : un utilisateur pourrait se faire passer pour un autre client en modifiant un cookie ou un paramètre
   - Solution : utiliser un JWT contenant l’id_client et vérifier sa validité (signature, expiration, correspondance avec les données demandées)

2. **Inclusion de fichiers non autorisés (LFI/RFI)**

   - Problème : injection de noms de fichiers ou chemins dans les paramètres pour charger du code arbitraire
   - Solution : définir des listes blanches (client, module, script) et interdire toute concaténation non contrôlée dans les chemins (fonction validateRequestParams dans security.php)

3. **Compromission de la clé secrète JWT**

   Problème : si la clé secrète utilisée pour signer les JWT est compromise, un attaquant peut générer des tokens valides et usurper des identités

   Solution :
   Utiliser une clé secrète complexe, et la stocker dans un fichier .env (il sera joint également en copie du mail de réponse),puis charger la clé via des variables d’environnement dans le code
