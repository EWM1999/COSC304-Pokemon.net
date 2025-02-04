import mysql.connector
import datetime
import decimal


class OrderDB:
    """Application for querying an order database"""
    
    def connect(self):
        """Makes a connection to the database and returns connection to caller"""
        try:
            print("Connecting to database.")
            # TODO: Fill in your connection information
            self.cnx = mysql.connector.connect(user='emedema', password='91175448', host='cosc304.ok.ubc.ca', database='db_emedema')
            return self.cnx
        except mysql.connector.Error as err:  
            print(err)       
            
    def init(self):
        """Creates and initializes the database"""
        fileName = "order.ddl"

        try:
            cursor = self.cnx.cursor()
            with open(fileName, "r") as infile:
                st = infile.read()
                commands = st.split(";")
                for line in commands:                   
                    # print(line.strip("\n"))
                    line = line.strip()
                    if line == "":  # Skip blank lines
                        continue 
                        
                    cursor.execute(line)
            
            cursor.close()
            self.cnx.commit()            
        except mysql.connector.Error as err:  
            print(err)
               
    def close(self):
        try:
            print("Closing database connection.")
            self.cnx.close()
        except mysql.connector.Error as err:  
            print(err)   
            
    def listAllCustomers(self):
        """ Returns a String with all the customers in the order database.  
            Format:
                CustomerId, CustomerName
                00000, A. Anderson 

            Return:
                String containing customers
        """
        
        print("Executing list all customers.")
        
        output = "CustomerId, CustomerName"
                
        cursor = self.cnx.cursor()
        query = "SELECT CustomerID, CustomerName from Customer;"
        cursor.execute(query)

        for (CustomerID, CustomerName) in cursor:
            output = output + "\n" + CustomerID +", "+CustomerName
        cursor.close()

        return output        

    def listCustomerOrders(self, customerId):
        """ Returns a String with all the orders for a given customer id.
     
            Note: May need to use getDate(). You should not retrieve all values as Strings.

            Format:
                OrderId, OrderDate, CustomerId, EmployeeId, Total
                01001, 2002-11-08, 00001, E0000, 1610.59
                
            Returns:
                String containing orders
        """
        
        # TODO: Similar to listAllCustomers(), execute query and store results in a string and return the string
        print("Executing list of all CustomerID Orders.")
        
        output = "OrderID, OrderDate, CustomerID, EmployeeID, Total"
                
        cursor = self.cnx.cursor()
        # TODO: Execute query and build output string
        query = "SELECT OrderId, OrderDate, CustomerID, EmployeeID, Total from Orders where CustomerID = "+customerId
        cursor.execute(query)
        for (OrderId, OrderDate, CustomerID, EmployeeID, Total) in cursor:

            output = output + "\n" + OrderId +", "+ OrderDate.strftime('%m/%d/%Y')+", "+ CustomerID+", "+EmployeeID+", "+str(Total)
        cursor.close()
        return output 
          
    
    def listLineItemsForOrder(self, orderId):
        """Returns a cursor with all line items for a given order id."""

        cursor = self.cnx.cursor(buffered = True)
        query = "SELECT * from Orders where OrderId = " + orderId
        cursor.execute(query)
        
        return cursor
    
    def computeOrderTotal(self, orderId):
        """Returns a cursor with a row containing the computed order total from the lineitems (named as orderTotal) for a given order id.
             Note: Do NOT just return the Orders.Total value."""

        cursor = self.cnx.cursor(buffered = True)
        query = "SELECT SUM(Total) AS orderTotal from Orders where OrderId =" +orderId
        cursor.execute(query)
        return cursor
    
    def addCustomer(self, customerId, customerName):
        """Inserts a customer into the database"""
        
        cursor = self.cnx.cursor()
        query = "INSERT INTO Customer (CustomerID, CustomerName) Values (\""+customerId+"\", \""+customerName+"\")"
        cursor.execute(query)
        self.cnx.commit()
        return cursor
        
    def deleteCustomer(self, customerId):
        """Deletes a customer from the database"""
        
        cursor = self.cnx.cursor()
        query = "DELETE FROM Customer where CustomerId = " + customerId
        cursor.execute(query)
        self.cnx.commit()
        return cursor
    
    def updateCustomer(self, customerId, customerName):
        """Updates a customer in the database"""
        
        cursor = self.cnx.cursor()
        query = "Update Customer set CustomerName = " + customerName +" where CustomerId = " + customerId
        cursor.execute(query)
        self.cnx.commit()
        return cursor
        
        
    def newOrder(self, orderId, customerId, orderDate, employeeId):
        """Inserts an order into the database"""
        cursor = self.cnx.cursor()
        query = "INSERT INTO Orders (OrderId, CustomerId, OrderDate, EmployeeId) VALUES (\""+orderId+"\",\""+customerID+"\",\""+orderDate+"\",\""+employeeId+"\")"
        cursor.execute(query)
        self.cnx.commit()
        return cursor   
        
    def newLineItem(self, orderId, proudctId, quantity, price):
        """Inserts a lineitem into the database"""
        cursor = self.cnx.cursor()
        query = "INSERT INTO OrderedProducts (orderId, proudctId, quantity, price) VALUES (%s, %s, %s, %s))"
        cursor.execute(query, (orderId, proudctId, quantity, price))
        self.cnx.commit()
        return cursor
        
    def updateOrderTotal(self, orderId, total):
        """Updates an order total in the database"""
        cursor = self.cnx.cursor()
        query = "UPDATE Orders SET Total = %s"
        cursor.execute(query, total)
        self.cnx.commit()
        return cursor

    def query1(self):
        """
        Returns the list of products that have not been in any order. Hint: Left join can be used instead of a subquery.
        """
        cursor = self.cnx.cursor()

        print("\nExecuting query #1.")

        query = 'SELECT p.id FROM Product AS p LEFT JOIN OrderProduct AS op ON p.id = op.product_id WHERE op.order_id IS NULL;'
        cursor.execute(query)
        return cursor

    def query2(self):
        """Returns the order ids and total amount where the order total does not equal the sum of quantity*price for all ordered products in the order."""
        
        print("\nExecuting query #2.")
        cursor = self.cnx.cursor()
        query = "SELECT Orders.OrderId, Orders.Total FROM Orders Inner Join OrderedProducts as op ON Orders.OrderID = op.OrderID GROUP BY Orders.OrderId, Orders.Total  HAVING SUM(op.Quantity*op.Price) != Orders.Total"
        cursor.execute(query)
        
        return cursor   

    def query3(self):
        """Return for each customer their id, name and average total order amount for orders starting on January 1, 2015 (inclusive). Only show customers that have placed at least 2 orders.
            Format:
                CustomerId, CustomerName, avgTotal
                00001, B. Brown, 489.952000


        SELECT CustomerId, CustomerName, avgTotal
        FROM 
        """
        
        print("\nExecuting query #3.")
        return None  
    
    def query4(self):
        """
        Return the employees who have had at least 2 distinct orders where some product on the order had quantity >= 5.
        Format:
            EmployeeId, EmployeeName, orderCount                
        """
        
        print("\nExecuting query #4.")
        return None
    
    # Do NOT change anything below here
    def resultSetToString(self, cursor, maxrows):
        output = ""
        cols = cursor.column_names
        output += "Total columns: "+str(len(cols))+"\n"
        output += cols[0]
        for i in range(1,len(cols)):
            output += ", "+cols[i]
        for row in cursor:
            output += "\n"+str(row[0])
            for i in range(1,len(cols)):
                output += ", "+str(row[i])
        output += "\nTotal results: "+str(cursor.rowcount)
        return output
                
# Main execution for testing
if __name__ == "__main__":
    orderDB = OrderDB()
    orderDB.connect()
    orderDB.init()

    print(orderDB.listAllCustomers())
    print(orderDB.listCustomerOrders("00001"))
    orderDB.listLineItemsForOrder("01000")
    orderDB.computeOrderTotal("01000")
    orderDB.addCustomer("11111", "Fred Smith")
    orderDB.updateCustomer("11111", "Freddy Smithers")
    orderDB.newOrder("22222", "11111", "2015-10-31", "E0001")
    orderDB.newLineItem("22222", "P0005", 5, "3.10")
    orderDB.newLineItem("22222", "P0007", 5, "2.25")
    orderDB.newLineItem("22222", "P0008", 5, "2.50")
    orderDB.deleteCustomer("11111")
    orderDB.deleteCustomer("00001")

    # Queries
    # Re-initialize all data
    orderDB.init()
    print(orderDB.resultSetToString(orderDB.query1(), 100))
    print(orderDB.resultSetToString(orderDB.query2(), 100))
    print(orderDB.resultSetToString(orderDB.query3(), 100))
    print(orderDB.resultSetToString(orderDB.query4(), 100))
            
    orderDB.close()