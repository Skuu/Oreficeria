CREATE TABLE Clienti(
    ID int(6) NOT NULL UNIQUE,
    nome varchar(25) NOT NULL,
    cognome varchar(25) NOT NULL,
    email varchar(35) NOT NULL UNIQUE,
    telefono varchar(10) NOT NULL UNIQUE,

    CONSTRAINT ChiavePrimaria PRIMARY KEY (ID)
);

CREATE TABLE Referenti(
    ID int(6) NOT NULL UNIQUE,
    nome varchar(25) NOT NULL,
    cognome varchar(25) NOT NULL,
    email varchar(35) NOT NULL UNIQUE,
    telefono varchar(10) NOT NULL UNIQUE,
    
    CONSTRAINT ChiavePrimaria PRIMARY KEY (ID)
);

CREATE TABLE Laboratori(
    ID int(6) NOT NULL UNIQUE,
    Referente int(6) NOT NULL,
    ragione_sociale varchar(25) NOT NULL UNIQUE,
    descrizione varchar(50) NOT NULL,
    indirizzo varchar(25) NOT NULL,
    telefono varchar(25) NOT NULL,

    CONSTRAINT ChiavePrimaria PRIMARY KEY (ID),
    CONSTRAINT ReferenteLaboratorio FOREIGN KEY (Referente) REFERENCES Referenti(ID)
);

CREATE TABLE Buste(
    ID int(6) NOT NULL UNIQUE AUTO_INCREMENT,
    Cliente int(6) NOT NULL,
    Laboratorio int(6) NOT NULL,
    tipologia varchar(10) NOT NULL,
    garanzia BIT(1) NOT NULL,
    importo int(10),
    tempo_stimato int(3) NOT NULL,
    stato varchar(15) NOT NULL,
    send_lab DATE,
    recv_lab DATE,
    send_off DATE,
    recv_off DATE,
    cassetto int(2),

    CONSTRAINT ChiavePrimaria PRIMARY KEY (ID),
    CONSTRAINT ClienteBusta FOREIGN KEY (Cliente) REFERENCES Clienti(ID),
    CONSTRAINT LaboratorioBusta FOREIGN KEY (Laboratorio) REFERENCES Laboratori(ID)
);

CREATE TABLE Utenti(
    username varchar(25) NOT NULL UNIQUE,
    password varchar(100) NOT NULL,

    CONSTRAINT ChiavePrimaria PRIMARY KEY (username)
)

-- admin:_S4..passxJ0eQ4JmtTQ

INSERT INTO Referenti(ID, nome, cognome, email, telefono) VALUES 
    (0, "Simone", "Sbardellati", "simonesbardellati@gmail.com", "3336101617" ),
    (1, "Marcello", "Merenda", "marcello.merenda@gmail.com", "3473026124" ),
    (2, "Marco", "Corsini", "marcocorsini@gmail.com", "3478968426" );

INSERT INTO Laboratori(ID, Referente, ragione_sociale, descrizione, indirizzo, telefono) VALUES
    (0, 0, "Simone Sbardellati SS", "Morellato, Marlù, Chrono24, Swatch", "San Polo, via del sarto, 25125", "3665498564"),
    (1, 1, "Marcello Merenda SS", "Stroili, Bluespirit, Rolex, Damante", "Castenedolo, via fiume, 25014", "3336216458"),
    (2, 2, "Marco Corsini SS", "Swarovski, Tiffany, Daniel Wellington, Lorenz", "Flero, via francesco, 25020", "4885692456");

INSERT INTO Clienti (ID, nome, cognome, email, telefono) VALUES
    (0, "Matteo", "Gaspari", "matteo.gaspari2005@gmail.com", "3443890038"),
    (1, "Valentina", "Truppia", "valentina.truppia05@gmail.com", "3665439295"),
    (2, "Domenico", "Burdi","burdidomenico@gmail.com", "3390269217"),
    (3, "Daniele", "Marchetti", "marchettidaniele@gmail.com", "3663141681"),
    (4, "Denny", "Lungu", "dennylungu@gmail.com", "3516442400"),
    (5, "Davide", "Zanoni", "zanoni.davide05@gmail.com", "3390269219"),
    (6, "Federico", "Bresciani", "fedept@gmail.com", "3200366654");
 
INSERT INTO Buste (ID, Cliente, Laboratorio, tipologia, garanzia, importo, tempo_stimato, stato, cassetto) VALUES
    (0, 0, 0, "gioielli", 0, 100, 5, "in corso", 1 ),
    (1, 1, 1, "orologi", 1, 700, 15, "non riparabile", 2 ),
    (2, 2, 1, "orologi", 1, 549, 23, "in corso", 1 ),
    (3, 3, 2, "orologi", 1, 399, 12, "non riparabile", 2 ),
    (4, 4, 0, "gioielli", 0, 200, 44, "in corso", 1 ),
    (5, 5, 2, "orologi", 0, 830, 2, "in corso", 1 ),
    (6, 6, 2, "gioielli", 0, 150, 1, "conclusa", 3 );
