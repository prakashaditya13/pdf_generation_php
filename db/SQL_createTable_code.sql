CREATE TABLE mytable(
   Inv_no               INTEGER  NOT NULL PRIMARY KEY 
  ,created_At           DATE  NOT NULL
  ,due_date             DATE  NOT NULL
  ,customer0Cust_name   VARCHAR(14) NOT NULL
  ,customer0address     VARCHAR(19) NOT NULL
  ,customer0email       VARCHAR(31) NOT NULL
  ,company0comp_name    VARCHAR(6) NOT NULL
  ,company0address      VARCHAR(9) NOT NULL
  ,company0email        VARCHAR(13) NOT NULL
);
INSERT INTO mytable(Inv_no,created_At,due_date,customer0Cust_name,customer0address,customer0email,company0comp_name,company0address,company0email) VALUES (12,'December 10, 2020','January 1, 2021','Aditya Prakash','Bhopal, gandhinagar','prakashaditya13011999@gmail.com','Goetra','New Delhi','XYZ@gmail.com');
