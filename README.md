# resilia
For the assessment I export what is in the google sheets and then created a page where you can upload it.  To read the file, I used SimpleXLSX (https://github.com/shuchkin/simplexlsx).
It will insert or update the Non Profit list since they can have status changes.  It will insert or ignore the user list in case there are duplicates.

It then will display the answers to the questions in the assessment by doing sql queries to pull the data and php to manipulate it.

I added two users to the table to verify the code works as intended

