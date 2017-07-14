-- Time Cards
CREATE TABLE `time_cards` (
  `id` INTEGER PRIMARY KEY AUTOINCREMENT, -- Unique ID
  `date` date NOT NULL,  -- Date of record
  `employee_id` varchar(255) NOT NULL, -- Employee ID
  `hours_worked` FLOAT NOT NULL,    -- Hours per record
  `job_group` varchar(1) NOT NULL,  -- Job group
  `job_group_effective_rate` INTEGER NOT NULL,  -- Rate applicable to group
  `time_report_id` int(11) NOT NULL  -- Time report filed
);

--  Payrolls
CREATE TABLE `payrolls` (
  -- `id` INTEGER PRIMARY KEY AUTOINCREMENT, -- Unique ID
  `employee_id` varchar(255) NOT NULL, -- Employee ID
  `pay_period_start_date` date NOT NULL,    -- Date pay period begins
  `pay_period_end_date` date NOT NULL,  -- Date pay period ends
  `total_hours` FLOAT NOT NULL,  -- Total number of hours per period
  `amount_paid` INTEGER NOT NULL,  -- Effective rate by total hours
  `status` varchar(255) NOT NULL DEFAULT '' -- Status of the pay period
);

-- Time Reports
CREATE TABLE `time_reports` (
  `id` INTEGER PRIMARY KEY AUTOINCREMENT, -- Unique ID
  `date_filed` date NOT NULL   -- Date pay period begins
);

