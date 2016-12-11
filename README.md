## App Description
The app is built on top of Zend's [MVC Skeleton App](https://framework.zend.com/downloads/skeleton-app) (which makes it look a lot bigger than it actually is). It has a minimal UI, and an simple sqlite database managed by an ORM framework. What I was trying to focus on is modelling the data flow, specifically, ensuring the integrity of whatever goes into data store. The idea was to tweak MVC to abstract service layer from controlleris and repositories, and the model layer, from repositories and entities.

The service layer gives me the modularity (for example, testing is easier, or adding REST controllers). With the models, the thinking was that that while relational algebra is beautiful, it's not always great at handling chaos -- that is, uh, real world data flows -- and modelling after the ORM dictates a structure that's not necessarily optimal for the business rules. That creates a design pressure to push the rules into the controllers, who in turn are tempted to start reaching for data, bypassing models. I always felt that the good answer, rather than telling developers to "never ever do it," would be to provide models capable of getting things done better than controllers (including messy, non-relational requirements). What I was trying to achieve was to put business rules into the models, and give them enough scope power to take care of their concerns. 

## Behavior
To illustrate the advantage of extracting models from the data store layer, I've added a handler for a situation when some of the data is valid, and some is not, within the same report. The behavior is to skip invalid records, save valid ones, and come back with a warning, without hitting the data store layer - which may or may not know how to deal with it (e.g. document database). 

The rest is per requirements. 

The are also some samples to triger an error, a warning, and a success response on the UI:
```
[project root]/uiTests/sample-with-no-id.csv - error
[project root]/uiTests/sample-with-some-nulls.csv - warning
[project root]/uiTests/sample.csv - success
[project root]/uiTests/sample.csv - error (id already exists)
```

## Where to find stuff
All code specific to the application is under 

```
[project root]/module/Application 
```
and is self-explanatory. 

To reset the database: 
```
[project root]$ git checkout data/db.db
```

## Environment
[PHP 7 and Apache on Debian](https://github.com/docker-library/php/blob/04a39b18812015e0ac7bfc84a1905897cad7b10d/7.0/apache/Dockerfile), [Zend 3 framework](https://framework.zend.com/learn)


## How to run the app: 
The application uses PHP Zend 3 framework and Sqlite database. It is relying on PHP 7 and PHP Composer, and can be run on Apache server. 
The included Docker and Vagrant files provide images with the framework's system dependencies preconfigured.

### Running in a Docker container: 
- Requires [Docker](https://www.docker.com)
1. Navigate into the application root
2. Build the image from Dockerfile, e.g. called zend-mvc:latest:
```
docker image build --tag zend-mvc:latest .   
```
3. Run the container.
The build may take a while. Once Docker responds with 
```
Successfully tagged zend-mvc:latest
```
run the container from the image, e.g. named "payroll-app" at localhost:8080 based on the container zend-mvc:latest created above:
```
docker run \
--name payroll-app \
-p 8080:80 \
-v "$PWD":/var/www \
-w /var/www \
-d \
zend-mvc:latest
```

This will forward container's port 80 to the localhost's 8080, mount the currrent directory as the container's /var/www - which is set up within the image as the Apache document root - and start Apache. 

4. Get PHP Composer to update dependencies. 
Once the Docker daemon responds with the container ID, log into its shell:
```
docker exec -it payroll-app bash
```
Once logged in, run
```
composer install --no-interaction --no-suggest
```
Composer may take a while and may not be very communicative. 
When Composer reports success, exit the shell. 

Alternatively, PHP Composer can be called on the host at the project's root, provided it is installed. 

The app should now be be available at localhost:8080 (or the port specified when launching).

### Running on Vagrant:
Requires: 
- [VirtualBox](https://www.virtualbox.org/wiki/Downloads)
- [Vagrant](https://www.vagrantup.com/downloads.html)

1. Navigate into the application root. 
2. Volume mounting and port forwarding is set within Vagrantfile. 
To change the port, edit the following line in Vagrantfile:
```
config.vm.network "forwarded_port", guest: 80, host: 8080
```
 and change the host value to the desired port number.
 
3. Run
```
vagrant up
```
4. Get PHP Composer to update its dependencies. 
Once the virtual machine boots up (may take a while), run
```
vagrant ssh -c 'composer install --no-interaction --no-suggest'
```
When PHP Composer pulls its dependencies (may take a while), the application should be available at the specified port at localhost, e.g. localhost:8080

---

# Wave Software Development Challenge

Applicants for the [Software
developer](https://wave.bamboohr.co.uk/jobs/view.php?id=1) role at Wave must
complete the following challenge, and submit a solution prior to the onsite
interview.

The purpose of this exercise is to create something that we can work on
together during the onsite. We do this so that you get a chance to collaborate
with Wavers during the interview in a situation where you know something better
than us (it's your code, after all!)

There isn't a hard deadline for this exercise; take as long as you need to
complete it. However, in terms of total time spent actively working on the
challenge, we ask that you not spend more than a few hours, as we value your
time and are happy to leave things open to discussion in the on-site interview.

Please use whatever programming language and framework you feel the most
comfortable with.

Feel free to email [dev.careers@waveapps.com](dev.careers@waveapps.com) if you
have any questions.

## Project Description

Imagine that this the early days of Wave's history, and that we are prototyping
a new payroll system with an early partner. Our partner is going to use our web
app to determine how much each employee should be paid in each _pay period_, so
it is critical that we get our numbers right.

The partner in question only pays its employees by the hour (there are no
salaried employees.) Employees belong to one of two _job groups_ which
determine their wages; job group A is paid $20/hr, and job group B is paid
$30/hr. Each employee is identified by a string called an "employee id" that is
globally unique in their system.

Hours are tracked per employee, per day in comma-separated value files (CSV).
Each individual CSV file is known as a "time report", and will contain:

1. A header, denoting the columns in the sheet (`date`, `hours worked`,
   `employee id`, `job group`)
1. 0 or more data rows
1. A footer row where the first cell contains the string `report id`, and the
   second cell contains a unique identifier for this report.

Our partner has guaranteed that:

1. Columns will always be in that order.
1. There will always be data in each column.
1. There will always be a well-formed header line.
1. There will always be a well-formed footer line.

An example input file named `sample.csv` is included in this repo.

### What your web-based application must do:

We've agreed to build the following web-based prototype for our partner.

1. Your app must accept (via a form) a comma separated file with the schema
   described in the previous section.
1. Your app must parse the given file, and store the timekeeping information in
   a relational database for archival reasons.
1. After upload, your application should display a _payroll report_. This
   report should also be accessible to the user without them having to upload a
   file first.
1. If an attempt is made to upload two files with the same report id, the
   second upload should fail with an error message indicating that this is not
   allowed.

The payroll report should be structured as follows:

1. There should be 3 columns in the report: `Employee Id`, `Pay Period`,
   `Amount Paid`
1. A `Pay Period` is a date interval that is roughly biweekly. Each month has
   two pay periods; the _first half_ is from the 1st to the 15th inclusive, and
   the _second half_ is from the 16th to the end of the month, inclusive.
1. Each employee should have a single row in the report for each pay period
   that they have recorded hours worked. The `Amount Paid` should be reported
   as the sum of the hours worked in that pay period multiplied by the hourly
   rate for their job group.
1. If an employee was not paid in a specific pay period, there should not be a
   row for that employee + pay period combination in the report.
1. The report should be sorted in some sensical order (e.g. sorted by employee
   id and then pay period start.)
1. The report should be based on all _of the data_ across _all of the uploaded
   time reports_, for all time.

As an example, a sample file with the following data:

<table>
<tr>
  <th>
    date
  </th>
  <th>
    hours worked
  </th>
  <th>
    employee id
  </th>
  <th>
    job group
  </th>
</tr>
<tr>
  <td>
    4/11/2016
  </td>
  <td>
    10
  </td>
  <td>
    1
  </td>
  <td>
    A
  </td>
</tr>
<tr>
  <td>
    14/11/2016
  </td>
  <td>
    5
  </td>
  <td>
    1
  </td>
  <td>
    A
  </td>
</tr>
<tr>
  <td>
    20/11/2016
  </td>
  <td>
    3
  </td>
  <td>
    2
  </td>
  <td>
    B
  </td>
</tr>
</table>

should produce the following payroll report:

<table>
<tr>
  <th>
    Employee ID
  </th>
  <th>
    Pay Period
  </th>
  <th>
    Amount Paid
  </th>
</tr>
<tr>
  <td>
    1
  </td>
  <td>
    1/11/2016 - 15/11/2016
  </td>
  <td>
    $300.00
  </td>
</tr>
  <td>
    2
  </td>
  <td>
    16/11/2016 - 30/11/2016
  </td>
  <td>
    $90.00
  </td>
</tr>
</table>

Your application should be easy to set up, and should run on either Linux or
Mac OS X. It should not require any non open-source software.

There are many ways that this application could be built; we ask that you build
it in a way that showcases one of your strengths. If you enjoy front-end
development, do something interesting with the interface. If you like
object-oriented design, feel free to dive deeper into the domain model of this
problem. We're happy to tweak the requirements slightly if it helps you show
off one of your strengths.

### Documentation:

Please modify `README.md` to add:

1. Instructions on how to build/run your application
1. A paragraph or two about what you are particularly proud of in your
   implementation, and why.

## Submission Instructions

1. Clone the repository.
1. Complete your project as described above within your local repository.
1. Ensure everything you want to commit is committed.
1. Create a git bundle: `git bundle create your_name.bundle --all`
1. Email the bundle file to [dev.careers@waveapps.com](dev.careers@waveapps.com)

## Evaluation

Evaluation of your submission will be based on the following criteria.

1. Did you follow the instructions for submission?
1. Did you document your build/deploy instructions and your explanation of what
   you did well?
1. Were models/entities and other components easily identifiable to the
   reviewer?
1. What design decisions did you make when designing your models/entities? Are
   they explained?
1. Did you separate any concerns in your application? Why or why not?
1. Does your solution use appropriate data types for the problem as described?
