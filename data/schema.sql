-- Time Card Records
CREATE TABLE `time_keeping_data` (
  `id` INTEGER PRIMARY KEY AUTOINCREMENT, -- Unique ID
  `date` date NOT NULL,  -- Date of record
  `employee_id` varchar(255) NOT NULL, -- Employee ID
  `hours_worked` smallint NOT NULL,    -- Hours per record
  `job_group` varchar(1) NOT NULL,  -- Job group
  `time_report_id` int(11) NOT NULL,  -- Time report filed
  `pay_period_start_date` date NOT NULL,    -- Date pay period begins
  `pay_period_end_date` date NOT NULL,  -- Date pay period ends
  `job_group_effective_rate` INTEGER NOT NULL  -- Rate applicable to group
);