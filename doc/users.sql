CREATE TABLE `userlist` (
  `username` varchar(50) NOT NULL,
  `password` varchar(45) NOT NULL,
  `givenname` varchar(45) NOT NULL,
  `familyname` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `role` varchar(5) NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1