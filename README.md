# CPSC304Project

Todo List:

1) Determine if "Is IngredientsInStock also a weak entity then? I would suggest looking into that. Regardless, do keep in mind that entities can only be the weak entity to ONE other entity. It cannot have more than one parent."
		We might be able to simplify Ingredients to just one table?
		i) Maybe the manager just queries the ingredients and their stock levels/expiry dates.
		ii) The manger then inserts ingredients into the IngredientsToOrder table and that would be what could be sent to the suppliers?
		
2)
