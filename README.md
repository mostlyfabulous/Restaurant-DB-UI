# CPSC304Project

Todo List:

1) Determine if "Is IngredientsInStock also a weak entity then? I would suggest looking into that. Regardless, do keep in mind that entities can only be the weak entity to ONE other entity. It cannot have more than one parent."
		We might be able to simplify Ingredients to just one table?
		i) Maybe the manager just queries the ingredients and their stock levels/expiry dates.
		ii) The manger then inserts ingredients into the IngredientsToOrder table and that would be what could be sent to the suppliers?
		
2) Use Assert statements when inserting tuples into IngredientsToOrder
3) Make IngredientsInStock a big table (add more columns)
4) Reform relation 'contains' from MenuItem to Ingredients






Demo requirements from the tentative marking scheme (each is 1 point):

GUI 
- We are accepting a text-based interface, as long as it is clearly laid out and isn’t missing any choices.  For those who used an actual GUI, it doesn’t need to be fancy.  Really fancy GUIs can be awarded a bonus point (see below)

Same Deliverables as Handed In? 
- The group shows the TA that the deliverables haven’t changed from what they handed in (e.g., timestamps). 
- Marks will be deducted appropriately in the final deliverables, if there is a difference. 

*Selection Query (Deliverable 8-10) DONE*
- The group picks one query from this category.  The group should show the before and after case (either by using SQL*Plus or their application program)

*INSERT (Deliverable 2) DONE*
- Did their program (not SQL*Plus or equivalent) perform a successful INSERT statement?  The group should show you the before and after case (either by using SQL*Plus or their application program).

*DELETE (Deliverable 3) DONE*
- Did their program (not SQL*Plus or equivalent) perform a successful DELETE statement?  The group should show you the before and after case (either by using SQL*Plus or their application program). 

*UPDATE (Deliverable 4) WIP*
- Did their program (not SQL*Plus or equivalent) perform a successful UPDATE statement?  The group should show you the before and after case (either by using SQL*Plus or their application program).  

Join Query (Deliverable 5 or 6) 
- The group picks one query from this category.  The group should show you the before and after case (either by using SQL*Plus or their application program). 

View  (Deliverable 11) 
- Did they create a VIEW (either by SQL*Plus or equivalent or their program), and then use the programto successfully access that view? 

Aggregation Query (Deliverable 7)
- The group demonstrates the use of aggregation (e.g., min, max, sum, average, or count).  

Division Query (new, but advertised deliverable)
- The group demonstrates the correct use of SQL division, including showing that the result changes after an INSERT or DELETE (which produces a different, but correct outcome).  This doesn’t necessarily have to be done in the program; it can be done dynamically (e.g., via SQL*Plus or equivalent).  

Users’ Data
- Was the data in their tables sufficient to demonstrate their project well? 

Other Demo Items and Technical Question

Group deductions

Bonus points











