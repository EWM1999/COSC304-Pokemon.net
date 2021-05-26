# Pokémon.net - Your Black Market Dealer of Pokémon.
Pokémon.net is a simple PHP website written as the final project for COSC 304 - Databases. It simulates an
online store where a user can search for and purchase items, create an account, reset a password via email, and see their order history. An admin can monitor all purchases and users, create new items to sell, remove items from store, and reset the database to a preset default.

Pokemon.net won [top final project of 2019](https://people.ok.ubc.ca/rlawrenc/teaching/304/Project/index.html).

The Pokemon.net source code is in the `pokemon_src` directory. All documentation is in the `documentation` directory. Any milestones that do not contribute to the source code are in the `assignments` folder.

## Contributors:
* **Emily Medema** - [emedema](https://github.com/emedema)
* **Kathryn Lecha** - [kzlecha](https://github.com/kzlecha)
* **Lauren St.Clair** - [laurenstclair](https://github.com/laurenstclair)
* **Noah Marshall**

## Deliverables
Below is a short summary of the final deliverables:
* Products
    * Search for product by name
    * Browse list of products
    * Filter product by type
    * Review Product
        * enter review
        * display reviews
        * restrict to one review per customer
* Shopping Cart
    * Add products to cart
    * View cart
    * update quantity and remove items
* Checkout
    * Checkout with Customer ID
    * Checkout with payment info
        * credit card (no validated for user security because it is a simulation)
        * paypal (on development account)
* User Account
    * create account
    * edit account
    * forgot password
    * login/logout
    * list user orders
* Administer
    * secured by login (must have admin account)
    * list all customers
    * report all sales
    * add/update/delete products
    * database restore
