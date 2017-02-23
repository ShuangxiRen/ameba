use newamabae;
CREATE TABLE Users( UserID      INTEGER UNSIGNED AUTO_INCREMENT,
                    username    VARCHAR(30) UNIQUE NOT NULL,
                    password    VARCHAR(20) NOT NULL,
                    email        VARCHAR(50) NOT NULL,
                    gender      VARCHAR(10),
                    age         INTEGER,
                    income      REAL DEFAULT 0,
                    rating          INTEGER NOT NULL DEFAULT 0,
                    status     INTEGER NOT NULL DEFAULT 0,
                    PRIMARY KEY (UserID));
                    
CREATE TABLE Phone( UserID     INTEGER UNSIGNED NOT NULL,
              phonenumber   VARCHAR(20) NOT NULL,
              PRIMARY KEY (UserID, phonenumber),
              FOREIGN KEY (UserID) REFERENCES Users (UserID)
                                  ON DELETE CASCADE);
                                            
CREATE TABLE Address( UserID     INTEGER UNSIGNED NOT NULL,
                state       VARCHAR(20) NOT NULL,
                city      VARCHAR(20) NOT NULL,
                street     VARCHAR(30) NOT NULL,
                zip        VARCHAR(20) NOT NULL,
                PRIMARY KEY (UserID, street),
                FOREIGN KEY (UserID) REFERENCES Users (UserID)
                                        ON DELETE CASCADE);
                                                  
CREATE TABLE Creditcard(UserID     INTEGER UNSIGNED NOT NULL,
            cardtype    VARCHAR(20) NOT NULL,
                 card_number   VARCHAR(20) NOT NULL,
                 expire     DATE NOT NULL,
                 PRIMARY KEY (UserID, card_number),
                 FOREIGN KEY (UserID) REFERENCES Users (UserID)
                                         ON DELETE CASCADE);
                                                                
CREATE TABLE Categories (CategoryID     INTEGER UNSIGNED AUTO_INCREMENT,
                         category_name  VARCHAR(20) NOT NULL,
                         PRIMARY KEY (CategoryID));

CREATE TABLE Category_map (MapID    INTEGER UNSIGNED AUTO_INCREMENT,
                           parentID INTEGER UNSIGNED NOT NULL,
                           PRIMARY KEY (MapID),
                           FOREIGN KEY (parentID) REFERENCES Categories(CategoryID)
                                                                 ON DELETE CASCADE);    

CREATE TABLE Suppliers(SupplierID    INTEGER UNSIGNED AUTO_INCREMENT,
                       username      VARCHAR(30) UNIQUE NOT NULL,
                       password      VARCHAR(20) NOT NULL,
                       compname      VARCHAR(100) NOT NULL,
                       address       VARCHAR(200) NOT NULL,
                       pcontact      VARCHAR(30) NOT NULL,
                       phone         VARCHAR(20) NOT NULL,
                       rating        INTEGER NOT NULL DEFAULT 0,
                       status     INTEGER NOT NULL DEFAULT 0,
                       PRIMARY KEY (SupplierID));

CREATE TABLE Items (ItemID        INTEGER UNSIGNED AUTO_INCREMENT,
          category   INTEGER UNSIGNED NOT NULL,
                    item_name     TEXT NOT NULL,
                    description   TEXT NOT NULL,
                    quantity   INTEGER NOT NULL,
                    shippinginfo  VARCHAR(50)  NOT NULL,
                    shippingprice REAL   NOT NULL,
                    uploadtime    DATETIME,
                    location      VARCHAR(50)  NOT NULL,
                    picture    TEXT,
                    source    INTEGER NOT NULL,
                    PRIMARY KEY (ItemID),
                    FOREIGN KEY (Category) REFERENCES Categories(CategoryID));
                    
CREATE TABLE Sale_items (ItemID        INTEGER UNSIGNED NOT NULL,
                       saleitemsource INTEGER NOT NULL,
                         price         REAL NOT NULL,
                         supplierid    INTEGER UNSIGNED DEFAULT 0,
                         sellerid    INTEGER UNSIGNED DEFAULT 0,
                         soldquantity  INTEGER UNSIGNED NOT NULL DEFAULT 0,
                         PRIMARY KEY (ItemID),
                         FOREIGN KEY (ItemID) REFERENCES Items(ItemID)
                                                    ON DELETE CASCADE);
                         
CREATE TABLE Auction_items(ItemID         INTEGER UNSIGNED NOT NULL,
                           SellerID       INTEGER UNSIGNED NOT NULL,  
                           reserve_price  REAL NOT NULL,
                           end_time       DATETIME NOT NULL,
                           numofbidder    INTEGER UNSIGNED NOT NULL DEFAULT 0,
                           status     INTEGER NOT NULL,
                           PRIMARY KEY (ItemID),
                           FOREIGN KEY (ItemID) REFERENCES Items(ItemID)
                                                     ON DELETE CASCADE,
                           FOREIGN KEY (SellerID) REFERENCES Users(UserID));
                           
CREATE TABLE Bidding (ItemID        INTEGER UNSIGNED NOT NULL,
                      bid_time      DATETIME NOT NULL,
                      bidder        INTEGER UNSIGNED NOT NULL,
                      money         REAL NOT NULL,
                      PRIMARY KEY (ItemID, bidder, bid_time),
                      FOREIGN KEY (ItemID) REFERENCES Auction_items(ItemID)
                                                          ON DELETE CASCADE,
                      FOREIGN KEY (bidder) REFERENCES Users(UserID)); 
                      
CREATE TABLE Orders (OrderID      INTEGER UNSIGNED AUTO_INCREMENT,
                     ItemID       INTEGER UNSIGNED NOT NULL,
                     source       INTEGER UNSIGNED NOT NULL,
                     category     INTEGER UNSIGNED NOT NULL,
                     quantity     INTEGER UNSIGNED NOT NULL, 
                     buyer        INTEGER UNSIGNED NOT NULL,
                     seller       INTEGER UNSIGNED NOT NULL DEFAULT 0,
                     supplier   INTEGER UNSIGNED NOT NULL DEFAULT 0,
                     order_time   DATETIME NOT NULL,
                     cardtype   VARCHAR(20) NOT NULL,
                     creditcard   VARCHAR(20) NOT NULL,
                     bidornot     INTEGER NOT NULL,
                     price    REAL NOT NULL,
                     amount    REAL NOT NULL,
                     shippingfee REAL NOT NULL,
                     status       INTEGER NOT NULL,
                     PRIMARY KEY (OrderID),
                     FOREIGN KEY (ItemID) REFERENCES Items(ItemID),
                     FOREIGN KEY (category) REFERENCES Categories(CategoryID));
                     
CREATE TABLE Rating(RatingID      INTEGER UNSIGNED AUTO_INCREMENT,
                    OrderID       INTEGER UNSIGNED NOT NULL,
                    buyer     INTEGER UNSIGNED NOT NULL,
                    seller    INTEGER UNSIGNED NOT NULL DEFAULT 0,
                    supplier   INTEGER UNSIGNED NOT NULL DEFAULT 0,
                    source    INTEGER NOT NULL,
                    comment       TEXT(1000),
                    comment_time  DATETIME NOT NULL,
                    score         INTEGER NOT NULL,
                    PRIMARY KEY (RatingID));
                    
CREATE TABLE Message (MessageID     INTEGER UNSIGNED AUTO_INCREMENT,
                      sendtime      DATETIME NOT NULL,
                      type          INTEGER NOT NULL, 
                      fromname      VARCHAR(30) NOT NULL,
                      toname        VARCHAR(30) NOT NULL,
                      title         TEXT NOT NULL,
                      message       TEXT(1000),
                      status        INTEGER NOT NULL,
                      PRIMARY KEY (MessageID));
                      
CREATE TABLE Wishlist (ItemID       INTEGER UNSIGNED NOT NULL,
                       quantity     INTEGER NOT NULL,
                       UserID       INTEGER UNSIGNED NOT NULL,
                       wishtime     DATE  NOT NULL,
                       PRIMARY KEY (ItemID, UserID),
                       FOREIGN KEY (ItemID) REFERENCES Items(ItemID)
                                                  ON DELETE CASCADE,
                       FOREIGN KEY (UserID) REFERENCES Users(UserID));                      


