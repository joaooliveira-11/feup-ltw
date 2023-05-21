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
DROP TABLE IF EXISTS User_Ban;

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
                     type TEXT NOT NULL, -- o type pode ser ASSIGN_REQUEST, TICKET_RESPONDED, etc(depois adiciona-se mais, dependendo das funcionalidades)
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
                        idHashtag INTEGER PRIMARY KEY,
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

CREATE TABLE User_Ban (
                    idUser INTEGER PRIMARY KEY REFERENCES User,
                    reason TEXT NOT NULL,
                    description TEXT
);

------------------------------------------------------------------------------------------
--------------------------------------Triggers--------------------------------------
------------------------------------------------------------------------------------------

CREATE TRIGGER insert_user_roles
AFTER INSERT ON User
FOR EACH ROW
    WHEN(NEW.idUser<>1)
BEGIN
        INSERT INTO User_Roles (idUser, idRole) VALUES (NEW.idUser, 1); --quando se regista um user, ele é um cliente.
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
                                       ('How do I change my password, email, username or name?', 'To make any change on your profile, you can click on profile and use the edit profile feature'),
                                       ('Why am I experiencing slow page load times?', 'Slow page load times can be caused by a variety of factors, including your internet connection, your device, and the website itself. Try clearing your browser cache and cookies, or using a different browser or device to see if that resolves the issue.'),
                                       ('How do I update my account information?', 'To update your account information, go to your account settings and select the information you would like to update. Make sure to save any changes you make.'),
                                       ('Why am I unable to access certain features?', 'If you are unable to access certain features, first make sure that you are logged in and that your account has the necessary permissions to access those features. If that doesn''t work, contact customer support for assistance.'),
                                       ('How can I add more information after creating a ticket?', 'If you want to add more information by talking to an agent, you will be able to use the messages feature on the ticket when the ticket is assigned to an agent'),
                                       ('What are common heart diseases?', 'Common heart diseases include coronary artery disease, heart failure, arrhythmias, and heart valve disorders.'),
                                       ('How often should I see a dermatologist?', 'The frequency of dermatologist visits depends on your specific skin concerns and any ongoing treatment plans. It is recommended to have regular check-ups, especially for individuals with skin conditions.'),
                                       ('What are the symptoms of a neurological disorder?', 'Symptoms of neurological disorders can vary widely, but they may include headaches, dizziness, numbness or tingling, muscle weakness, and changes in coordination or balance.'),
                                       ('How can I improve my mental well-being?', 'Improving mental well-being can be achieved through various strategies, including regular exercise, practicing relaxation techniques, maintaining a healthy lifestyle, seeking social support, and engaging in activities that bring joy and fulfillment.'),
                                       ('What vaccines are recommended for children?', 'Recommended vaccines for children include those for diseases such as measles, mumps, rubella, diphtheria, tetanus, pertussis, polio, hepatitis, influenza, and meningitis, among others.'),
                                       ('What are common ENT problems?', 'Common ENT problems include sinusitis, ear infections, tonsillitis, allergies, deviated septum, snoring, and voice disorders.'),
                                       ('How often should I have an eye exam?', 'It is generally recommended to have a comprehensive eye exam every 1-2 years, or as advised by your eye care professional, to monitor vision changes, detect eye conditions, and ensure overall eye health.'),
                                       ('What services does a family medicine physician provide?', 'Family medicine physicians provide a wide range of services, including preventive care, routine check-ups, management of chronic conditions, vaccinations, and minor procedures.'),
                                       ('How do I schedule an appointment with a cardiologist?', 'To schedule an appointment with a cardiologist, you can call our clinic directly or use our online appointment booking system.'),
                                       ('What are some common treatments for skin cancer?', 'Common treatments for skin cancer include surgical excision, cryotherapy, radiation therapy, and topical medications.'),
                                       ('What are the warning signs of a stroke?', 'Warning signs of a stroke include sudden numbness or weakness of the face, arm, or leg (especially on one side of the body), confusion, trouble speaking or understanding speech, sudden severe headache, and trouble with vision.'),
                                       ('What are the signs of depression?', 'Signs of depression can include persistent sadness or feelings of emptiness, loss of interest or pleasure in activities, changes in appetite or weight, sleep disturbances, fatigue, feelings of worthlessness or guilt, difficulty concentrating, and thoughts of death or suicide.');
     


INSERT INTO User_Departments (idUser, idDepartment)
VALUES
  (1, 3),
  (1, 4),
  (2, 5),
  (2, 6),
  (3, 7),
  (3, 8),
  (4, 1),
  (4, 2),
  (5, 3),
  (5, 4),
  (6, 5),
  (6, 6),
  (7, 7),
  (7, 8),
  (8, 1),
  (8, 2),
  (9, 3),
  (9, 4),
  (10, 5),
  (10, 6),
  (11, 7),
  (11, 8),
  (12, 1),
  (12, 2),
  (13, 3),
  (13, 4),
  (14, 5),
  (14, 6),
  (15, 7),
  (15, 8),
  (16, 1),
  (16, 2),
  (17, 3),
  (17, 4),
  (18, 5),
  (18, 6),
  (19, 7),
  (19, 8),
  (20, 1),
  (20, 2),
  (21, 3),
  (21, 4),
  (22, 5),
  (22, 6),
  (23, 7),
  (23, 8),
  (24, 1),
  (24, 2),
  (25, 3),
  (25, 4);

INSERT INTO User_Roles(idUser, idRole) VALUES (1,3);
INSERT INTO User_Roles(idUser, idRole) VALUES (2,3);
INSERT INTO User_Roles(idUser, idRole) VALUES (3,3);
INSERT INTO User_Roles(idUser, idRole) VALUES (4,2);
INSERT INTO User_Roles(idUser, idRole) VALUES (5,2);

INSERT INTO User_Roles(idUser, idRole) VALUES (6,2);
INSERT INTO User_Roles(idUser, idRole) VALUES (7,2);
INSERT INTO User_Roles(idUser, idRole) VALUES (8,2);
INSERT INTO User_Roles(idUser, idRole) VALUES (9,2);
INSERT INTO User_Roles(idUser, idRole) VALUES (10,2);

INSERT INTO User_Roles(idUser, idRole) VALUES (11,2);
INSERT INTO User_Roles(idUser, idRole) VALUES (12,2);
INSERT INTO User_Roles(idUser, idRole) VALUES (13,2);
INSERT INTO User_Roles(idUser, idRole) VALUES (14,2);
INSERT INTO User_Roles(idUser, idRole) VALUES (15,2);

INSERT INTO User_Roles(idUser, idRole) VALUES (16,2);
INSERT INTO User_Roles(idUser, idRole) VALUES (17,2);
INSERT INTO User_Roles(idUser, idRole) VALUES (18,2);
INSERT INTO User_Roles(idUser, idRole) VALUES (19,2);
INSERT INTO User_Roles(idUser, idRole) VALUES (20,2);

INSERT INTO User_Roles(idUser, idRole) VALUES (21,2);
INSERT INTO User_Roles(idUser, idRole) VALUES (22,2);
INSERT INTO User_Roles(idUser, idRole) VALUES (23,2);
INSERT INTO User_Roles(idUser, idRole) VALUES (24,2);
INSERT INTO User_Roles(idUser, idRole) VALUES (25,2);


INSERT INTO Hashtag (name) VALUES ('hospital');
INSERT INTO Hashtag (name) VALUES ('healthcare');
INSERT INTO Hashtag (name) VALUES ('medicine');
INSERT INTO Hashtag (name) VALUES ('doctor');
INSERT INTO Hashtag (name) VALUES ('nurse');
INSERT INTO Hashtag (name) VALUES ('patientcare');
INSERT INTO Hashtag (name) VALUES ('emergency');
INSERT INTO Hashtag (name) VALUES ('surgery');
INSERT INTO Hashtag (name) VALUES ('ICU');
INSERT INTO Hashtag (name) VALUES ('pediatrics');
INSERT INTO Hashtag (name) VALUES ('oncology');
INSERT INTO Hashtag (name) VALUES ('radiology');
INSERT INTO Hashtag (name) VALUES ('pharmacy');
INSERT INTO Hashtag (name) VALUES ('mentalhealth');
INSERT INTO Hashtag (name) VALUES ('rehabilitation');
INSERT INTO Hashtag (name) VALUES ('healthtech');
INSERT INTO Hashtag (name) VALUES ('telemedicine');
INSERT INTO Hashtag (name) VALUES ('publichealth');
INSERT INTO Hashtag (name) VALUES ('wellness');
INSERT INTO Hashtag (name) VALUES ('medicalresearch');

INSERT INTO Ticket (title, description, priority, create_date, cria, resolve, idDepartment)
VALUES
    ('Chest pain and shortness of breath', 'I am experiencing severe chest pain and shortness of breath. It started after physical exertion.', 2, '21-05-2023', 1, NULL, 1),
    ('Heart palpitations', 'I have been having episodes of rapid and irregular heartbeats. Its been happening frequently lately.', 2, '21-05-2023', 2, NULL, 1),
    ('Persistent skin rash', 'I have a persistent skin rash on my arms and legs. Its itchy and has been spreading.', 3, '21-05-2023', 3, NULL, 2),
    ('Acne treatment', 'I have been struggling with severe acne for a while now. I have tried over-the-counter products, but they haven''t been effective.', 1, '21-05-2023', 3, NULL, 2), 
    ('Chronic migraines', 'I have been suffering from chronic migraines for the past few months. The pain is debilitating and affects my daily life.', 1, '21-05-2023', 4, NULL, 3),
    ('Numbness and tingling', 'I have been experiencing numbness and tingling in my hands and feet. It comes and goes but has been happening more frequently.', 2, '21-05-2023', 4, NULL, 3),
    ('Anxiety and panic attacks', 'I have been dealing with frequent anxiety and panic attacks. It has started affecting my work and personal life.', 4, '21-05-2023', 5, NULL, 4),
    ('Depression and low mood', 'I have been feeling extremely down and have lost interest in activities I used to enjoy. I need help dealing with my depression.', 2, '21-05-2023', 5, NULL, 4), 
    ('Childs recurring fever', 'My child has been having recurring fevers for the past week. It comes and goes, and there are no other obvious symptoms.', 2, '21-05-2023', 5, NULL, 5),
    ('Developmental concerns', 'I have noticed some delays in my childs speech and motor skills. I would like to discuss it with a pediatrician.', 2, '21-05-2023', 5, NULL, 5),
    ('Hearing loss', 'I have noticed a significant decrease in my hearing ability over the past few months. I would like to have it evaluated.', 4, '21-05-2023', 6, NULL, 6),
    ('Recurrent sinus infections', 'I have been experiencing recurrent sinus infections, accompanied by facial pain and pressure.', 2, '21-05-2023', 6, NULL, 6),
    ('Irregular heartbeat', 'I have been experiencing episodes of irregular heartbeat and occasional chest discomfort. It concerns me, and I would like to get it checked.', 1, '21-05-2023', 6, NULL, 1),   
    ('Chronic eczema flare-up', 'My eczema has been flaring up consistently for the past few weeks. The itching and redness are becoming unbearable.', 2, '21-05-2023', 7, NULL, 2),  
    ('Persistent migraines', 'I have been suffering from persistent migraines that are affecting my daily life. Over-the-counter pain relievers do not provide long-lasting relief.', 1, '21-05-2023', 8, NULL, 3),  
    ('Stress and anxiety management', 'I have been under a lot of stress lately, and its affecting my mental well-being. I would like to seek guidance on stress management techniques.', 2, '21-05-2023', 9, NULL, 4),
    ('Childs immunization schedule', 'I need assistance in understanding and keeping track of my childs immunization schedule. I want to ensure that they receive all the necessary vaccines.', 1, '21-05-2023', 10, NULL, 5),  
    ('Chronic sinus congestion', 'I have been experiencing chronic sinus congestion, which is affecting my ability to breathe comfortably. I need a consultation with an ENT specialist.', 2, '22-05-2023', 11, NULL, 6),   
    ('Blurry vision and eye strain', 'My vision has been blurry, and I experience eye strain, especially after working on the computer for extended periods. I would like to get an eye examination.', 1, '22-05-2023', 12, NULL, 7), 
    ('Routine check-up', 'It has been a while since my last check-up. I would like to schedule a routine check-up to ensure everything is in order.', 4, '22-05-21', 13, NULL, 8),
    ('Chest pain and shortness of breath', 'I am experiencing severe chest pain and shortness of breath. It started after physical exertion.', 3, '22-05-21', 14, NULL, 1),
    ('Heart palpitations', 'I have been having episodes of rapid and irregular heartbeats. It has been happening frequently lately.', 5, '22-05-2023', 15, NULL, 1),
    ('Fatigue and dizziness', 'I have been feeling extremely fatigued and dizzy, especially after any physical activity. It concerns me.', 3, '22-05-2023', 16, NULL, 2),    
    ('Persistent skin rash', 'I have a persistent skin rash on my arms and legs. Its itchy and has been spreading.', 3, '22-05-2023', 17, NULL, 2),
    ('Acne treatment', 'I have been struggling with severe acne for a while now. I have tried over-the-counter products, but they havent been effective.', 1, '22-05-2023', 18, NULL, 3),
    ('Dry and itchy scalp', 'I have been experiencing a dry and itchy scalp, along with dandruff. Its becoming increasingly uncomfortable.', 2, '22-05-2023', 19, NULL, 4),
    ('Chronic migraines', 'I have been suffering from chronic migraines for the past few months. The pain is debilitating and affects my daily life.', 1, '22-05-2023', 20, NULL, 4),
    ('Numbness and tingling', 'I have been experiencing numbness and tingling in my hands and feet. It comes and goes but has been happening more frequently.', 2, '22-05-2023', 21, NULL, 5),
    ('Memory loss and confusion', 'I have been experiencing memory loss and confusion, especially with recalling recent events. Its starting to worry me.', 3, '22-05-2023', 22, NULL, 6),   
    ('Anxiety and panic attacks', 'I have been dealing with frequent anxiety and panic attacks. It has started affecting my work and personal life.', 4, '22-05-2023', 23, NULL, 6),
    ('Depression and low mood', 'I have been feeling extremely down and have lost interest in activities I used to enjoy. I need help dealing with my depression.', 24, '22-05-2023', 2, NULL, 6),
    ('Stress management techniques', 'I have been struggling to cope with stress. I would like to learn effective stress management techniques.', 3, '22-05-2023', 25, NULL, 7),
    ('Hearing loss', 'I have noticed a significant decrease in my hearing ability over the past few months. I would like to have it evaluated.', 4, '22-05-2023', 26, NULL, 6),
    ('Recurrent sinus infections', 'I have been experiencing recurrent sinus infections, accompanied by facial pain and pressure.', 2, '22-05-2023', 26, NULL, 6),
    ('Blurry vision and eye strain', 'My vision has been blurry, and I experience eye strain, especially after working on the computer for extended periods. I would like to get an eye examination.', 1, '22-05-2023', 26, NULL, 7),
    ('Routine check-up', 'It has been a while since my last check-up. I would like to schedule a routine check-up to ensure everything is in order.', 2, '22-05-2023', 26, NULL, 8),
    ('Chest pain and shortness of breath', 'I am experiencing severe chest pain and shortness of breath. It started after physical exertion.', 2, '23-05-2023', 27, NULL, 1),
    ('Heart palpitations', 'I have been having episodes of rapid and irregular heartbeats. Its been happening frequently lately.', 2, '23-05-2023', 28, NULL, 2),
    ('Persistent skin rash', 'I have a persistent skin rash on my arms and legs. Its itchy and has been spreading.', 3, '23-05-2023', 29, NULL, 3),
    ('Acne treatment', 'I have been struggling with severe acne for a while now. I have tried over-the-counter products, but they haven''t been effective.', 1, '23-05-2023', 30, NULL, 4),
    ('Chronic migraines', 'I have been suffering from chronic migraines for the past few months. The pain is debilitating and affects my daily life.', 1, '24-05-2023', 1, NULL, 3),
    ('Anxiety and panic attacks', 'I have been dealing with frequent anxiety and panic attacks. It has started affecting my work and personal life.', 4, '24-05-2023', 2, NULL, 4),
    ('Childs recurring fever', 'My child has been having recurring fevers for the past week. It comes and goes, and there are no other obvious symptoms.', 2, '24-05-2023', 3, NULL, 5),
    ('Hearing loss', 'I have noticed a significant decrease in my hearing ability over the past few months. I would like to have it evaluated.', 4, '24-05-2023', 4, NULL, 6),
    ('Chronic eczema flare-up', 'My eczema has been flaring up consistently for the past few weeks. The itching and redness are becoming unbearable.', 2, '24-05-2023', 5, NULL, 7);
    




