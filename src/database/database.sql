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
DROP TABLE IF EXISTS Inquiry;

DROP TABLE IF EXISTS User_Roles;
DROP TABLE IF EXISTS User_Departments;
DROP TABLE IF EXISTS Ticket_Hashtags;
DROP TABLE IF EXISTS Ticket_Status;

DROP TRIGGER IF EXISTS insert_user_roles;
DROP TRIGGER IF EXISTS insert_ticket_status;
DROP TRIGGER IF EXISTS update_ticket_resolve;

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

CREATE TABLE Inquiry(
                     idInquiry INTEGER PRIMARY KEY AUTOINCREMENT,
                     idUserReceiving INTEGER REFERENCES User, --user que recebeu a notificação
                     idUserGiving INTEGER REFERENCES User, --user que "fez" a notificação (pode ser opcional)
                     idTicket INTEGER REFERENCES Ticket,
                     type TEXT NOT NULL, -- o type pode ser ASSIGN_REQUEST, TICKET_REPONDED, etc(depois adiciona-se mais, dependendo das funcionalidades)
                     date DATE

);

CREATE TABLE Department(
                           idDepartment INTEGER PRIMARY KEY AUTOINCREMENT,
                           name TEXT NOT NULL,
                           description Text,
                           CONSTRAINT UNIQUE_Department_name UNIQUE (name)
);

CREATE TABLE Ticket(
                       idTicket INTEGER PRIMARY KEY AUTOINCREMENT,
                       title TEXT NOT NULL,
                       description TEXT NOT NULL,
                       priority INTEGER NOT NULL,
                       create_date DATE,
                       cria INTEGER REFERENCES User,
                       resolve INTEGER REFERENCES User,
                       idDepartment INTEGER REFERENCES Department,
                       CONSTRAINT CHECK_Ticket_createdate CHECK (create_date >= 2023-01-01)
);

CREATE TABLE Hashtag(
                        idTicket INTEGER PRIMARY KEY,
                        name TEXT NOT NULL,
                        CONSTRAINT UNIQUE_Hashtag_name UNIQUE (name)
);

CREATE TABLE Reply(
                      idReply INTEGER PRIMARY KEY AUTOINCREMENT,
                      message TEXT NOT NULL,
                      create_date DATE,
                      idTicket INTEGER REFERENCES Ticket,
                      idUser INTEGER REFERENCES User,
                      CONSTRAINT CHECK_Reply_createdate CHECK (create_date >= 2023-01-01)
);

CREATE TABLE Status(
                       idStatus INTEGER PRIMARY KEY AUTOINCREMENT,
                       stage TEXT NOT NULL,
                       constraint Unique_Stage UNIQUE (stage)
);

CREATE TABLE User_Roles(
                           id_random INTEGER PRIMARY KEY AUTOINCREMENT,
                           idUser INTEGER REFERENCES User,
                           idRole INTEGER REFERENCES Role
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
                              id_random INTEGER PRIMARY KEY AUTOINCREMENT,
                              idTicket INTEGER REFERENCES Ticket,
                              idStatus INTEGER REFERENCES Status,
                              idDepartment INTEGER REFERENCES Department,
                              agent INTEGER REFERENCES User,
                              date DATE

);

CREATE TABLE FAQ (
                     idFAQ INTEGER PRIMARY KEY AUTOINCREMENT,
                     question TEXT NOT NULL,
                     answer TEXT NOT NULL
);
------------------------------------------------------------------------------------------
--------------------------------------Triggers--------------------------------------
------------------------------------------------------------------------------------------

CREATE TRIGGER insert_user_roles
AFTER INSERT ON User
FOR EACH ROW
BEGIN
    INSERT INTO User_Roles (idUser, idRole) VALUES (NEW.idUser, 2); --quando se regista um user, ele é um cliente.
END;

CREATE TRIGGER insert_ticket_status
    AFTER INSERT ON Ticket
    FOR EACH ROW
BEGIN
    INSERT INTO Ticket_Status (idTicket, idStatus, idDepartment, agent, date)
    VALUES (NEW.idTicket, 1, NEW.idDepartment, NULL, NEW.create_date);
END;


CREATE TRIGGER update_ticket_resolve
    AFTER Insert ON Ticket_Status
    FOR EACH ROW
    WHEN NEW.idStatus = 1
BEGIN
    UPDATE Ticket SET resolve = NULL WHERE idTicket = NEW.idTicket;
END;

CREATE TRIGGER insert_inquiry_after_reply
    AFTER INSERT ON Reply
    FOR EACH ROW
BEGIN
    INSERT INTO Inquiry (idUserReceiving, idUserGiving, idTicket, message, type, date)
    SELECT CASE WHEN NEW.idUser = T.cria THEN T.resolve ELSE T.cria END, NEW.idUser, NEW.idTicket, NEW.message, 'TICKET_RESPONDED', NEW.create_date
    FROM Ticket T
    WHERE T.idTicket = NEW.idTicket;
END;

------------------------------------------------------------------------------------------
--------------------------------------Data Insertion--------------------------------------
------------------------------------------------------------------------------------------

INSERT INTO Role (name) VALUES ('CLIENT');
INSERT INTO Role (name) VALUES ('AGENT');
INSERT INTO Role (name) VALUES ('ADMIN');

INSERT INTO User (name,username, email, password) VALUES ('Bernardo Pinto', 'berna', 'Berna@gmail.com', '$2y$12$33SGDgv2ZFZ5IB5nGDjoJexTscy362rdyF7XFo83toNekCOGFGc0.');
INSERT INTO User (name,username, email, password) VALUES ('Francisca Guimaraes', 'kika', 'kika@gmail.com', '$2y$12$33SGDgv2ZFZ5IB5nGDjoJexTscy362rdyF7XFo83toNekCOGFGc0.');
INSERT INTO User (name,username, email, password) VALUES ('Jony Pierre', 'jonyp', 'jonyp@gmail.com', '$2y$12$33SGDgv2ZFZ5IB5nGDjoJexTscy362rdyF7XFo83toNekCOGFGc0.');
INSERT INTO User (name,username, email, password) VALUES ('Fabiana Oliveira', 'fabiana', 'Fabiana@gmail.com', '$2y$12$33SGDgv2ZFZ5IB5nGDjoJexTscy362rdyF7XFo83toNekCOGFGc0.');
INSERT INTO User (name,username, email, password) VALUES ('Samuel Alex', 'samu2k23', 'samu2k23@gmail.com', '$2y$12$33SGDgv2ZFZ5IB5nGDjoJexTscy362rdyF7XFo83toNekCOGFGc0.');
INSERT INTO User (name,username, email, password) VALUES ('Franklin Silva', 'franklin', 'franklin@gmail.com', '$2y$12$33SGDgv2ZFZ5IB5nGDjoJexTscy362rdyF7XFo83toNekCOGFGc0.');
INSERT INTO User (name,username, email, password) VALUES ('Luisona Neymar', 'luisa', 'luisa@gmail.com', '$2y$12$33SGDgv2ZFZ5IB5nGDjoJexTscy362rdyF7XFo83toNekCOGFGc0.');
INSERT INTO User (name,username, email, password) VALUES ('Bruna Marquezine', 'bruna', 'bruna@gmail.com', '$2y$12$33SGDgv2ZFZ5IB5nGDjoJexTscy362rdyF7XFo83toNekCOGFGc0.');
INSERT INTO User (name,username, email, password) VALUES ('Cristiano Ronaldo', 'cristiano', 'cr7@gmail.com', '$2y$12$33SGDgv2ZFZ5IB5nGDjoJexTscy362rdyF7XFo83toNekCOGFGc0.');
INSERT INTO User (name,username, email, password) VALUES ('Neymar Toupeira', 'neymito', 'neymito@gmail.com', '$2y$12$33SGDgv2ZFZ5IB5nGDjoJexTscy362rdyF7XFo83toNekCOGFGc0.');

INSERT INTO User (name, username, email, password) VALUES ('John Doe', 'johndoe', 'johndoe@example.com', '$2y$12$33SGDgv2ZFZ5IB5nGDjoJexTscy362rdyF7XFo83toNekCOGFGc0.');
INSERT INTO User (name, username, email, password) VALUES ('Jane Smith', 'janesmith', 'janesmith@example.com', '$2y$12$33SGDgv2ZFZ5IB5nGDjoJexTscy362rdyF7XFo83toNekCOGFGc0.');
INSERT INTO User (name, username, email, password) VALUES ('Michael Johnson', 'michaeljohnson', 'michaeljohnson@example.com', '$2y$12$33SGDgv2ZFZ5IB5nGDjoJexTscy362rdyF7XFo83toNekCOGFGc0.');
INSERT INTO User (name, username, email, password) VALUES ('Sarah Thompson', 'sarahthompson', 'sarahthompson@example.com', '$2y$12$33SGDgv2ZFZ5IB5nGDjoJexTscy362rdyF7XFo83toNekCOGFGc0.');
INSERT INTO User (name, username, email, password) VALUES ('David Lee', 'davidlee', 'davidlee@example.com', '$2y$12$33SGDgv2ZFZ5IB5nGDjoJexTscy362rdyF7XFo83toNekCOGFGc0.');
INSERT INTO User (name, username, email, password) VALUES ('Emily Davis', 'emilydavis', 'emilydavis@example.com', '$2y$12$33SGDgv2ZFZ5IB5nGDjoJexTscy362rdyF7XFo83toNekCOGFGc0.');
INSERT INTO User (name, username, email, password) VALUES ('Matthew Harris', 'matthewharris', 'matthewharris@example.com', '$2y$12$33SGDgv2ZFZ5IB5nGDjoJexTscy362rdyF7XFo83toNekCOGFGc0.');
INSERT INTO User (name, username, email, password) VALUES ('Olivia Brown', 'oliviabrown', 'oliviabrown@example.com', '$2y$12$33SGDgv2ZFZ5IB5nGDjoJexTscy362rdyF7XFo83toNekCOGFGc0.');
INSERT INTO User (name, username, email, password) VALUES ('Daniel Martinez', 'danielmartinez', 'danielmartinez@example.com', '$2y$12$33SGDgv2ZFZ5IB5nGDjoJexTscy362rdyF7XFo83toNekCOGFGc0.');
INSERT INTO User (name, username, email, password) VALUES ('Sophia Taylor', 'sophiataylor', 'sophiataylor@example.com', '$2y$12$33SGDgv2ZFZ5IB5nGDjoJexTscy362rdyF7XFo83toNekCOGFGc0.');

INSERT INTO User (name,username, email, password) VALUES ('Michael Jackson', 'mjackson', 'mjackson@gmail.com', '$2y$12$33SGDgv2ZFZ5IB5nGDjoJexTscy362rdyF7XFo83toNekCOGFGc0.');
INSERT INTO User (name,username, email, password) VALUES ('Antonio Mezzero', 'antoniomezzero', 'antoniomezzero@gmail.com', '$2y$12$33SGDgv2ZFZ5IB5nGDjoJexTscy362rdyF7XFo83toNekCOGFGc0.');
INSERT INTO User (name,username, email, password) VALUES ('Martino Mezzero', 'martino', 'martino@gmail.com', '$2y$12$33SGDgv2ZFZ5IB5nGDjoJexTscy362rdyF7XFo83toNekCOGFGc0.');
INSERT INTO User (name,username, email, password) VALUES ('Miguel Margarido', 'magicmike', 'magicmike@gmail.com', '$2y$12$33SGDgv2ZFZ5IB5nGDjoJexTscy362rdyF7XFo83toNekCOGFGc0.');
INSERT INTO User (name,username, email, password) VALUES ('Mario Ferreira', 'forgett', 'forgett@gmail.com', '$2y$12$33SGDgv2ZFZ5IB5nGDjoJexTscy362rdyF7XFo83toNekCOGFGc0.');
INSERT INTO User (name,username, email, password) VALUES ('Martim Aroso', 'martimaroso', 'martimaroso@gmail.com', '$2y$12$33SGDgv2ZFZ5IB5nGDjoJexTscy362rdyF7XFo83toNekCOGFGc0.');
INSERT INTO User (name,username, email, password) VALUES ('Joao Caravela', 'caravela10', 'caravela10@gmail.com', '$2y$12$33SGDgv2ZFZ5IB5nGDjoJexTscy362rdyF7XFo83toNekCOGFGc0.');
INSERT INTO User (name,username, email, password) VALUES ('Hugo Torgo', 'preto', 'preto@gmail.com', '$2y$12$33SGDgv2ZFZ5IB5nGDjoJexTscy362rdyF7XFo83toNekCOGFGc0.');
INSERT INTO User (name,username, email, password) VALUES ('Constança Guedes', 'cguedes', 'cguedes@gmail.com', '$2y$12$33SGDgv2ZFZ5IB5nGDjoJexTscy362rdyF7XFo83toNekCOGFGc0.');
INSERT INTO User (name,username, email, password) VALUES ('Pedro Diniz', 'pedrodiniz', 'pedrodiniz@gmail.com', '$2y$12$33SGDgv2ZFZ5IB5nGDjoJexTscy362rdyF7XFo83toNekCOGFGc0.');


INSERT INTO Department (name, description) VALUES
                                               ('Cardiology', 'This department specializes in the diagnosis, treatment, and management of conditions related to the heart and cardiovascular system.'),
                                               ('Dermatology', 'This department deals with the diagnosis and treatment of conditions related to the skin, hair, and nails.'),
                                               ('Neurology', 'This department specializes in the diagnosis and treatment of conditions related to the nervous system, including the brain, spinal cord, and peripheral nerves.'),
                                               ('Psychology', 'This department focuses on the assessment, diagnosis, and treatment of mental health conditions and emotional well-being.'),
                                               ('Pediatrics', 'This department specializes in the medical care of infants, children, and adolescents. Pediatricians provide preventive care, diagnose and treat illnesses, and monitor the growth and development of young patients.'),
                                               ('Otorhinolaryngology', 'This department deals with the diagnosis and treatment of conditions related to the ear, nose, and throat.'),
                                               ('Ophthalmology', 'This department focuses on the diagnosis and treatment of conditions related to the eyes and vision.'),
                                               ('General and Family Medicine', 'This department provides comprehensive primary care services for individuals of all ages, including preventive care, health screenings, and management of acute and chronic medical conditions.');

INSERT INTO Status (stage) VALUES ('OPEN');
INSERT INTO Status (stage) VALUES ('ASSIGNED');
INSERT INTO Status (stage) VALUES ('CLOSED');

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




INSERT INTO User_Departments(idUser, idDepartment) VALUES (2,1);
INSERT INTO User_Departments(idUser, idDepartment) VALUES (1,1);
INSERT INTO User_Departments(idUser, idDepartment) VALUES (1,2);

