-- ----------------------- --
-- Overall Analysis Counts --
-- ----------------------- --

-- Combine Tables into General Overview --
SELECT `visit`.`visit_type`, `calculators`.`pageid`, `useage`.`date`
	FROM `visit`
	INNER JOIN `useage` ON `visit`.`vid` = `useage`.`vid`
    INNER JOIN `calculators` ON `useage`.`pid` = `calculators`.`pid`;

-- Number of Total Visits to PhamCalcs --
SELECT COUNT(*) AS `Total Interactions` FROM `useage`;

-- Total Number of Each Type of Visit (visit or submission) --
SELECT `visit`.`visit_type`, COUNT(*) AS `Number of Visits` FROM `useage`
    INNER JOIN `visit`
    ON `visit`.`vid` = `useage`.`vid`
    GROUP BY `useage`.`vid`;

-- Total Number of Visits per Page (calculator) --
SELECT `calculators`.`pageid`, COUNT(*) AS `Number of Visits` FROM `useage`
    INNER JOIN `calculators`
    ON `calculators`.`pid` = `useage`.`pid`
    GROUP BY `useage`.`pid`;


-- ---------------------- --
-- Count Metrics (totals) --
-- ---------------------- --

-- Total Number of Visits per Page per Submission Type --
SELECT `calculators`.`pageid`, `visit`.`visit_type`, COUNT(*) AS `Number of Visits` FROM `useage`
    INNER JOIN `calculators` ON `calculators`.`pid` = `useage`.`pid`
    INNER JOIN `visit` ON `useage`.`vid` = `visit`.`vid`
    GROUP BY `useage`.`pid`, `visit`.`visit_type`
    ORDER BY `calculators`.`pageid`, `visit`.`visit_type` DESC;

-- Total Number of Visits per Day Irrespective of Visit Type --
SELECT DATE(`date`) AS `date`, COUNT(*) AS `Number of Visits` FROM `useage`
    GROUP BY DATE(`date`)
    ORDER BY `useage`.`date` ASC;

-- Total Number of Each Interaction Type per Day --
SELECT COUNT(*) AS `Number of Visits`, `visit`.`visit_type`, DATE(`useage`.`date`) AS `date` FROM `useage`
    INNER JOIN `visit` ON `useage`.`vid` = `visit`.`vid`
    GROUP BY DATE(`useage`.`date`), `useage`.`vid`
    ORDER BY `useage`.`vid` ASC, DATE(`useage`.`date`) ASC;
    
-- Total Number of Visits per Page per Day Irrespective of visit type  --
SELECT COUNT(*) AS `Number of Visits`, `calculators`.`pageid`, DATE(`useage`.`date`) AS `date` FROM `useage`
    INNER JOIN `calculators`
    ON `useage`.`pid` = `calculators`.`pid`
    GROUP BY DATE(`useage`.`date`), `useage`.`pid`
    ORDER BY `useage`.`pid` ASC, DATE(`useage`.`date`) ASC;

-- Total Number of Visits and Submissions per Page per Day --
SELECT `visit`.`visit_type`, COUNT(*) AS `Number of Visits`, `calculators`.`pageid`, DATE(`useage`.`date`) AS `date` FROM `useage`
    INNER JOIN `calculators`ON `useage`.`pid` = `calculators`.`pid`
    INNER JOIN `visit` ON `useage`.`vid` = `visit`.`vid`
    GROUP BY DATE(`useage`.`date`), `useage`.`pid`, `visit`.`visit_type`
    ORDER BY `useage`.`pid` ASC, DATE(`useage`.`date`) ASC, `visit`.`visit_type` DESC;


-- ----------------------- --
-- Percentage Calculations --
-- ----------------------- --

-- Percentage of Each Type of Visit --
SELECT `visit`.`visit_type`, (COUNT(*)/(SELECT COUNT(*) FROM `useage`) * 100) AS `Percentage of Visits` FROM `useage`
    INNER JOIN `visit`
    ON `visit`.`vid` = `useage`.`vid`
    GROUP BY `useage`.`vid`;

-- Percentage of Visits per Page (calculator) with Respect to Visit Type --
SELECT `calculators`.`pageid`,`visit`.`visit_type`, (COUNT(*)/(SELECT COUNT(*) FROM `useage`) * 100) AS `Percentage of Visits` FROM `useage`
    INNER JOIN `calculators` ON `calculators`.`pid` = `useage`.`pid`
    INNER JOIN `visit` ON `visit`.`vid` = `useage`.`vid`
    GROUP BY `useage`.`pid`, `visit`.`vid`;

-- Percentage of Visits per Page (calculator) --
SELECT `calculators`.`pageid`,`visit`.`visit_type`, (COUNT(*)/(SELECT COUNT(*) FROM `useage` WHERE `vid` = 1) * 100) AS `Percentage of Visits` FROM `useage`
    INNER JOIN `calculators` ON `calculators`.`pid` = `useage`.`pid`
    INNER JOIN `visit` ON `visit`.`vid` = `useage`.`vid`
    WHERE `visit`.`visit_type` = 'visit'
    GROUP BY `useage`.`pid`, `visit`.`vid`;

-- Percentage of Submissions per Page (calculator) with Respect to Visit Type --
SELECT `calculators`.`pageid`,`visit`.`visit_type`, (COUNT(*)/(SELECT COUNT(*) FROM `useage` WHERE `vid` = 2) * 100) AS `Percentage of Visits` FROM `useage`
    INNER JOIN `calculators` ON `calculators`.`pid` = `useage`.`pid`
    INNER JOIN `visit` ON `visit`.`vid` = `useage`.`vid`
    WHERE `visit`.`visit_type` = 'submit'
    GROUP BY `useage`.`pid`, `visit`.`vid`;

-- Percentage of submissions per visit overall (Conversion Rate) --
SELECT (COUNT(*)/(SELECT COUNT(*) FROM `useage` WHERE `vid` = 1) * 100) AS `Conversion Rate` FROM `useage`
	WHERE `vid` = 2;

-- Percentage of submissions per visit per page (Conversion Rate per page) --
SELECT `visits`.`pageid`, `submissions`.`submission_count`, `visits`.`visit_count`, (`submissions`.`submission_count`/`visits`.`visit_count` * 100) AS `Conversion Rate` FROM (
    SELECT `calculators`.`pageid`, COUNT(*) AS `visit_count` FROM `useage`
		JOIN `calculators` ON `useage`.`pid` = `calculators`.`pid`
		WHERE `useage`.`vid` = 1
		GROUP BY `useage`.`pid`, `useage`.`vid`
) AS `visits`
INNER JOIN (
	SELECT `calculators`.`pageid`, COUNT(*) AS `submission_count` FROM `useage`
		JOIN `calculators` ON `useage`.`pid` = `calculators`.`pid`
		WHERE `useage`.`vid` = 2
		GROUP BY `useage`.`pid`, `useage`.`vid`
) AS `submissions`
ON `visits`.`pageid` = `submissions`.`pageid`;


-- --------------- --
-- Averaged Visits --
-- --------------- --

-- Average Number of Visits to Site per Day --
SELECT AVG(`visit_number`.`Number of Visits`) AS `Average Number of Visits per Day` FROM (
    SELECT COUNT(*) AS `Number of Visits`, DATE(`date`) AS `date` FROM `useage`
        GROUP BY DATE(`date`)
) AS `visit_number`;

-- Alternate Method of Calculating Average Number of Visit to Site per Day --
-- Normalizes visit total to total number of days application has been running (the rest of the average calculation are similar to this one)
SELECT (COUNT(*)/(SELECT DATEDIFF((SELECT MAX(`date`) FROM `useage`),(SELECT MIN(`date`) FROM `useage`)))) AS `Average Number of Visits per Day` FROM `useage`;

-- Average Number of Each Visit Type per Day --
SELECT `visit`.`visit_type`, (COUNT(*)/(SELECT DATEDIFF((SELECT MAX(`date`) FROM `useage`),(SELECT MIN(`date`) FROM `useage`)))) AS `Average Number of Visit Types per Day`
	FROM `useage`
    INNER JOIN `visit` on `useage`.`vid` = `visit`.`vid`
    GROUP BY `visit`.`visit_type`;

-- Average Number of Visits per Page per Day Irrespective of visit type --
SELECT `calculators`.`pageid`, (COUNT(*)/(SELECT DATEDIFF((SELECT MAX(`date`) FROM `useage`),(SELECT MIN(`date`) FROM `useage`)))) AS `Average Number of Visits per Day`
	FROM `useage`
    INNER JOIN `calculators` ON `useage`.`pid` = `calculators`.`pid`
    GROUP BY `calculators`.`pageid`;

-- Average Number of Visits and Submissions per Page per Day --
SELECT `calculators`.`pageid`, `visit`.`visit_type`, (COUNT(*)/(SELECT DATEDIFF((SELECT MAX(`date`) FROM `useage`),(SELECT MIN(`date`) FROM `useage`)))) AS `Average Number of Visits per Day`
	FROM `useage`
    INNER JOIN `calculators` ON `useage`.`pid` = `calculators`.`pid`
    INNER JOIN `visit` ON `useage`.`vid` = `visit`.`vid`
    GROUP BY `calculators`.`pageid`, `visit`.`visit_type`
    ORDER BY `calculators`.`pageid`, `visit`.`visit_type` DESC;