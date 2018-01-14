## Description
The app is a basic accounting tool.
It runs in a browser, displays a UI, takes in a CSV document with a set of "time card" records, or "time report," uniquely identified by a "time report id". Each "time card" contains a number of hours worked by an "employee" on a certain date, and a pay rate of the "employee," called "group". When a "time report" is uploaded, the app validates it, and then saves the data set to the database. In parallel, it generates a "payroll report" per employee per pay period, calculated on the basis of the group rate of the "employee" multiplied by sum total of hours within each by-monthly pay period. The payroll is displayed beneath the upload UI, and updated every time a "time report" is saved. 

## Rules and behavior
- Each Time Card record belongs with a unique Time Report identified by a Time Report id
- Each Time Report (uploaded as a CSV dataset) must have at least one valid Time Card record, to be saved
- A valid Time Card record has no nulls
- Time Report may have invalid Time Card records, but only valid records are saved
- Upload results and/or errors are communicated back to the UI

## Concept
Rules are contained within stack-agnostic, isolated and testable Model layer. 
Service layer communicates requests from front end to Model and reports back feedback.
Repository is called onto by Model to deal with vendor-specific data layer.
Layers beyond the model (front end, data management) leverage their respective frameworks. 


## Stack
- Zend 3 PHP framework (MVC and dependency injection) 
- PHP (model)
- Doctrine (database management)
- Postgres (database)  


## Sandwich Tests
1. Model: cover rules 
2. Service: cover communication and feedback


## Running the app

### Docker: 
 
1. Navigate to project root
2. In config/autoload/local.php, update database host name to 'postgres', as follows:

```
...
'host' => 'postgres'
...
```

3. At project root, run commands:

```
docker-compose up -d
```
```
docker-compose run payroll-app bash -c 'composer install --no-interaction --no-suggest'
```
```
docker-compose run payroll-app bash -c './vendor/bin/doctrine-module --no-interaction migrations:migrate'
```

##### Tests:
```
docker-compose exec payroll-app bash -c 'composer test'
```

##### Load in browser:  
```
http://localhost:8080
```

### Vagrant:
1. Navigate to project root
2. In config/autoload/local.php, update database host name to 'localhost', as follows:

```
...
'host' => 'localhost'
...
```

3. At project root, run commands:
```
vagrant up
```
```
vagrant ssh -c 'composer install --no-interaction --no-suggest'
```
```
vagrant ssh -c './vendor/bin/doctrine-module --no-interaction migrations:migrate'
```

##### Tests:
```
vagrant ssh -c 'composer test'
```

##### Load in browser:  
```
http://localhost:4321
```

