PRAGMA foreign_keys=on;

.mode columns
.headers on
.nullvalue NULL

DROP TABLE IF EXISTS User;
DROP TABLE IF EXISTS Role;
DROP TABLE IF EXISTS Department;
DROP TABLE IF EXISTS Ticket;
DROP TABLE IF EXISTS Hashtag;
DROP TABLE IF EXISTS Reply;
DROP TABLE IF EXISTS Status;
DROP TABLE IF EXISTS FAQ;

DROP TABLE IF EXISTS User_Roles;
DROP TABLE IF EXISTS User_Departments;
DROP TABLE IF EXISTS Ticket_Hashtags;
DROP TABLE IF EXISTS Ticket_Status;

CREATE TABLE User (
    idUser INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    username TEXT NOT NULL,
    email TEXT NOT NULL,
    password TEXT NOT NULL,
    CONSTRAINT UNIQUE_User_username UNIQUE (username),
    CONSTRAINT UNIQUE_User_email UNIQUE (email)
);

CREATE TABLE Role(
    idRole INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    CONSTRAINT CHECK_Role_name CHECK (name = 'ADMIN' OR name = 'CLIENT' OR name = 'AGENT')
);

CREATE TABLE Department(
    idDepartment INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    CONSTRAINT UNIQUE_Department_name UNIQUE (name)
);

CREATE TABLE Ticket(
    idTicket INTEGER PRIMARY KEY AUTOINCREMENT, 
    title TEXT NOT NULL,
    description TEXT NOT NULL,
    priority INTEGER NOT NULL,
    create_date DATE,
    cria REFERENCES User,
    resolve REFERENCES User,
    idDepartment REFERENCES Department,
    CONSTRAINT CHECK_Ticket_createdate CHECK (create_date >= 2023-01-01)
);

CREATE TABLE Hashtag(
    idTicket INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    CONSTRAINT UNIQUE_Hashtag_name UNIQUE (name)
);

CREATE TABLE Reply(
    idReply INTEGER PRIMARY KEY AUTOINCREMENT,
    message TEXT NOT NULL,
    create_date DATE,
    idTicket REFERENCES Ticket,
    idUser INTEGER REFERENCES User,
    CONSTRAINT CHECK_Reply_createdate CHECK (create_date >= 2023-01-01)
);

CREATE TABLE Status(
    idStatus INTEGER PRIMARY KEY AUTOINCREMENT,
    stage TEXT NOT NULL,
    CONSTRAINT CHECK_Status_status CHECK (stage = 'OPEN' OR stage = 'SOLVED' OR stage = 'CLOSED')
);

CREATE TABLE User_Roles(
    idUser INTEGER REFERENCES User,
    idRole INTEGER REFERENCES Role,
    PRIMARY KEY (idUser, idRole)
);

CREATE TABLE User_Departments(
    idUser INTEGER REFERENCES User,
    idDepartment INTEGER REFERENCES Department,
    PRIMARY KEY (idUser, idDepartment)
);

CREATE TABLE Ticket_Hashtags(
    idTicket INTEGER REFERENCES Ticket,
    idHashtag INTEGER REFERENCES Hashtag,
    PRIMARY KEY (idTicket, idHashtag)
);

CREATE TABLE Ticket_Status(
    idTicket INTEGER REFERENCES Ticket,
    idStatus REFERENCES Status,
    date DATE,
    PRIMARY KEY (idTicket, idStatus)
);

CREATE TABLE FAQ (
    idFAQ INTEGER PRIMARY KEY AUTOINCREMENT,
    question TEXT NOT NULL,
    answer TEXT NOT NULL
);
------------------------------------------------------------------------------------------

INSERT INTO User (name,username, email, password) VALUES ('João Oliveira', 'JonyP', 'jonyp@gmail.com', '$2y$12$J5mhGYOlUn/h2bExfeF.rOdQPmHOFkT1S7yLCXvQrqpOJ55VDAL42');
INSERT INTO FAQ (question, answer) VALUES
  ('How do I reset my password?', 'To reset your password, go to the login page and click on the "Forgot Password" link. Enter your email address and follow the instructions in the email you receive to reset your password.'),
  ('Why am I experiencing slow page load times?', 'Slow page load times can be caused by a variety of factors, including your internet connection, your device, and the website itself. Try clearing your browser cache and cookies, or using a different browser or device to see if that resolves the issue.'),
  ('I am having trouble making a payment, what should I do?', 'If you are having trouble making a payment, first make sure that you have entered your payment information correctly. If that doesn''t work, try using a different payment method or contacting customer support for assistance.'),
  ('How do I update my account information?', 'To update your account information, go to your account settings and select the information you would like to update. Make sure to save any changes you make.'),
  ('What should I do if I have not received my order?', 'If you have not received your order, first check your order confirmation email for the estimated delivery date. If the estimated delivery date has passed, contact customer support for assistance.'),
  ('Why am I seeing an error message?', 'Error messages can be caused by a variety of factors, including incorrect login information, server errors, and browser issues. Try clearing your browser cache and cookies, or using a different browser or device to see if that resolves the issue.'),
  ('How do I cancel my subscription?', 'To cancel your subscription, go to your account settings and select the subscription you would like to cancel. Follow the instructions to cancel your subscription.'),
  ('Why am I unable to access certain features?', 'If you are unable to access certain features, first make sure that you are logged in and that your account has the necessary permissions to access those features. If that doesn''t work, contact customer support for assistance.'),
  ('How do I get a refund?', 'To request a refund, contact customer support and provide your order number and a description of the issue. Refunds are typically processed within a few business days.'),
  ('Why am I receiving spam emails?', 'If you are receiving spam emails, make sure to mark them as spam and delete them. Additionally, you can adjust your email settings to filter out spam emails in the future.'),
  ('How do I contact customer support?', 'To contact customer support, go to the "Contact Us" page on our website and fill out the form with your name, email address, and a description of your issue. We will get back to you as soon as possible.');

