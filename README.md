* Titlte
A simple exchange inteface for specified products

* Description
A simple web interface application where you can choose a product from the list and you get back extra information for that product and price in other monatery. 
The information of the products reside in a database and are fetched with an ajax request. 
The original price is in euro's and the other monatery prices are calculated with the exchange rates from an external API (fixer.io).
The application makes use of object oriented programming (interfaces, class extension etc).
Regarding frontend it uses the jquery library for the ajax requests adn the injection of the responses in de interface.
It also uses very simple styling and a very basic responsive functionality. In small screens (less than 500px) the content of 2 columns is put in 2 lines.

* Installation
Use the given MySQL schema found in api/Config/schema to create the db structure and setup the db connection
