# coatNclothes
E-Commerce module ICT EPSIC

## API
> Laravel Rest API

## WWW
> Vue.js and vue-material css

## Documentation
> Documentation du projet

# Requêtes http
## Index
1. [Requêtes GET](#get)
2. [Requêtes POST](#post)
3. [Requêtes PATCH](#patch-modifications)
4. [Requêtes PUT](#put-ajouts)
4. [Requêtes DELETE](#delete)

## GET
### /products/
> Retourne tous les produits
#### JSON
```
{  
  "products_list":[  
    {  
      "id":1,
      "name":"T-Shirt Pigeon de Madagascare"
    },
    {  
      "id":2,
      "name":"T-Shirt baleine bleu"
    },
    {  
      "id":3,
      "name":"Pantalon court pour aveugle"
    }
  ],
  "products_number":3
}

```

### /products/{id}
> Retourne un produit selon son id
#### JSON
```
{  
  "product_id":2,
  "product_name":"T-Shirt baleine bleu",
  "product_description":"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam risus mauris, placerat ut condimentum non",
  "product_price":56.5,
  "product_colors":[  
    "blue",
    "green",
    "red"
  ],
  "product_size":[  
    "L",
    "XL",
    "S"
  ],
  "product_brand":"Nike",
  "product_picture":"http:\/\/monapi\/dl\/folder\/picture.jpg"
}


```

### /categories/
> Retourne toutes les catégories
```
{
    data: {
        
    }
}
```

### /category/{id}
> Retourne une catégorie selon son id
```
{
    data: {
        
    }
}
```

### /category/{id}/products
> Retourne les produits d'un catégorie selon son id
```
{
    data: {
        
    }
}
```

### /{auth}/basket/
> Retourne le panier d'achats
```
{
    data: {
        
    }
}
```

### /{auth}/wishlists/
> Retourne les listes de souhaits
```
{
    data: {
        
    }
}
```

### /{auth}/wishlist/{id}
> Retourne une liste de souhaits selon son id
```
{
    data: {
        
    }
}
```

### /{auth}/user/{id}
> Retourne un utilisateur selon son id
```
{
    data: {
        
    }
}
```

### /{auth}/users/
> Retourne tous les utilisateurs
```
{
    data: {
        
    }
}
```

### /{auth}/orders/
> Retourne toutes les commandes
```
{
    data: {
        
    }
}
```

### /{auth}/user/{id}/orders
> Retoune les commandes d'utilisateur selon son id
```
{
    data: {
        
    }
}
```

### /{auth}/user/{id}/order/{id}
> Retourne une commande d'un utilisateur selon son id
```
{
    data: {
        
    }
}
```

### /logout/
> Déconnexion


## POST

### /login/
#### Postfield: username, password
> Connexion
```
{
    data: {
        
    }
}
```
### /signup/
#### Postfield: username, email, password, fsname, name, adress, npa, locality, gender
> Création d'un utilisateur
```
{
    data: {
        
    }
}
```

### /{auth}/password
#### Postfield: password
> Modification du mot de passe d'un utilisateur
```
{
    data: {
        
    }
}
```

### /{auth}/profilepicture/
#### Postfield: pic
> Ajout d'une photo de profil
```
{
    data: {
        
    }
}
```

## PATCH (modifications)

### /{auth}/user/{id}/
#### Postfield: email, fsname, name, adress, npa, locality, gender
> Modification des données utilisateur
```
{
    data: {
        
    }
}
```
### /{auth}/submitbasket/
#### Postfield:
> Validation du panier
```
{
    data: {
        
    }
}
```

### /{auth}/addwishlisttobasket/{id}
#### Postfield:
> Ajout d'une wishlist selon son id au panier
```
{
    data: {
        
    }
}
```

### /{auth}/addtowishlist/{id}
#### Postfield:
> Ajout d'une article à la liste de souhait selon son id
```
{
    data: {
        
    }
}
```

### /{auth}/addtobasket/
#### Postfield:
> Ajout d'un article au panier
```
{
    data: {
        
    }
}
```

## PUT (ajouts)

## DELETE

### /{auth}/wishlist/{id}
#### Postfield:
> Supprimer une liste de souhait
```
{
    data: {
        
    }
}
```

### /{auth}/wishlist/{id}/product/{id}
#### Postfield:
> Supprimer un article d'une liste de souhait
```
{
    data: {
        
    }
}
```

### /{auth}/basket/product/{id}
#### Postfield:
> Supprimer un article du panier
```
{
    data: {
        
    }
}
```

### /{auth}/user/{id}
#### Postfield:
> Supprimer un utlisateur
```
{
    data: {
        
    }
}
```
