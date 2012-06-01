select i.* from incident i inner join incident_category ic on i.id = ic.incident_id where ic.category_id in (10,16) group by i.id having
count(distinct ic.category_id) = 2;

 select i.* from incident i inner join incident_category ic on i.id = ic.incident_id where ic.category_id in (14,31) group by i.id having
count(distinct ic.category_id) = 2;

select ic.incident_id, count(ic.incident_id) from incident_category ic where category_id in (10,16)

SELECT DISTINCT i.id incident_id,
                i.incident_title,
                i.incident_description,
                i.incident_date,
                i.incident_mode,
                i.incident_active,
                i.incident_verified,
                i.location_id,
                l.country_id,
                l.location_name,
                l.latitude,
                l.longitude
FROM incident i
INNER JOIN LOCATION l ON (i.location_id = l.id)
INNER JOIN incident_category ic ON (ic.incident_id = i.id)
INNER JOIN category c ON (ic.category_id = c.id)
WHERE i.incident_active = 1
  AND (c.id IN (16,10)
	   OR c.id IN (19, 10)
       OR c.parent_id IN (16,10)
	   OR c.parent_id IN (19,10))
  AND c.category_visible = 1
GROUP BY i.id HAVING count(DISTINCT ic.category_id) = 2
ORDER BY i.incident_date DESC

SELECT DISTINCT i.id incident_id,
                i.incident_title,
                i.incident_description,
                i.incident_date,
                i.incident_mode,
                i.incident_active,
                i.incident_verified,
                i.location_id,
                l.country_id,
                l.location_name,
                l.latitude,
                l.longitude
FROM incident i
INNER JOIN LOCATION l ON (i.location_id = l.id)
INNER JOIN incident_category ic ON (ic.incident_id = i.id)
INNER JOIN category c ON (ic.category_id = c.id)
WHERE i.incident_active = 1
  AND (c.id IN (16,
                19,
                10)
       OR c.parent_id IN (16,
                          19,
                          10))
  AND c.category_visible = 1
GROUP BY i.id HAVING count(DISTINCT ic.category_id) = 3
ORDER BY i.incident_date DESC

SELECT c.id, c.parent_id, c.category_title FROM category c WHERE c.id = 10 AND  GROUP BY c.parent_id
UNION ALL
SELECT c.id, c.parent_id, c.category_title FROM category c WHERE c.id = 16 GROUP BY c.parent_id 
UNION ALL 
SELECT c.id, c.parent_id, c.category_title FROM category c WHERE c.id = 19 GROUP BY c.parent_id 



SELECT c1.parent_id, count(*)
FROM category c1
GROUP BY c1.parent_id
HAVING c1.parent_id <> 38
IN (
SELECT c2.id
FROM category c2
WHERE c2.parent_id = 38
)

SELECT parent_id, count(*)
FROM category
WHERE parent_id
IN (
   SELECT id
   FROM category
   WHERE parent_id = 0
)
GROUP BY parent_id;

SELECT c1.category_title FROM category c1
INNER JOIN category c2 ON c1.parent_id <> c2.parent_id AND c3.parent_id <> c2.parent_id
INNER JOIN category c3 ON c1.parent_id <> c3.parent_id AND c2.parent_id <> c2.parent_id
WHERE c1.id = 10 AND c2.id = 16 AND c2.id = 19;



UNION ALL 
SELECT c1.category_title FROM category c1
INNER JOIN category c2 ON c1.parent_id <> c2.parent_id
WHERE c1.id = 10 AND c2.id = 19

SELECT
    c1.category_title AS category,
    c2.category_title AS subcategory
FROM category c1
JOIN category c2
ON c1.id = c2.parent_id
ORDER BY c1.category_title, c2.category_title;


SELECT i.incident_title
FROM incident i
INNER JOIN incident_category ic ON ic.incident_id = i.id
LEFT JOIN category c1 ON c1.id = ic.category_id AND c1.id = 10
LEFT JOIN category c2 ON c2.id = ic.category_id AND c2.id = 16
LEFT JOIN category c3 ON c3.id = ic.category_id AND c3.id = 19
WHERE c1.id IS NOT NULL AND c2.id IS NOT NULL AND c3.id IS NOT NULL;


SELECT i.incident_title, c1.id, c2.id
FROM incident i
INNER JOIN incident_category ic ON ic.incident_id = i.id
LEFT JOIN category c1 ON c1.id = ic.category_id AND c1.id = 10
LEFT JOIN category c2 ON c2.id = ic.category_id AND c2.id = 16
WHERE c1.id IS NOT NULL AND c2.id IS NOT NULL;


SELECT i.id, i.incident_title, c1.id, c2.id
FROM incident i
INNER JOIN incident_category ic ON ic.incident_id = i.id AND ic.category_id IN
(SELECT c.id FROM category c WHERE c.id = 10
UNION ALL
SELECT c.id FROM category c WHERE c.id = 16)
WHERE c1.id IS NOT NULL AND c2.id IS NOT NULL
GROUP BY i.id


SELECT i.incident_title FROM incident i WHERE i.id IN
(SELECT ic.incident_id FROM incident_category ic WHERE ic.category_id = 10
UNION ALL
SELECT ic.incident_id FROM incident_category ic WHERE ic.category_id = 16)

SELECT  DISTINCT ic.incident_id
        FROM    incident_category ic
        WHERE   ic.category_id = 10
        OR ic.category_id = 16

SELECT DISTINCT ic.incident_id
FROM incident_category ic
WHERE ic.category_id IN



select *
from item_id t0
left join category_id t1 on t1.itemId=t0.Id and t1.gemres = 5
left join category_id t2 on t2.itemId=t0.Id and t2.gemres = 8
left join category_id t3 on t3.itemId=t0.Id and t3.gemres = 9
where (t1.Id is not null and t2.Id is not null and t3.Id is not null)


SELECT DISTINCT i.incident_title, ic.category_id
FROM incident i
INNER JOIN LOCATION l ON (i.location_id = l.id)
INNER JOIN incident_category ic ON (ic.incident_id = i.id)
INNER JOIN category c ON (ic.category_id = c.id)
WHERE i.incident_active = 1
  AND (c.id IN (10,16,19)
       OR c.parent_id IN (10,16,19))
  AND c.category_visible = 1
GROUP BY i.id HAVING count(DISTINCT ic.category_id) = 2
ORDER BY i.incident_date DESC



SELECT DISTINCT i.incident_title
FROM incident i
INNER JOIN LOCATION l ON (i.location_id = l.id)
INNER JOIN incident_category ic ON (ic.incident_id = i.id)
INNER JOIN category c ON (ic.category_id = c.id)
WHERE i.incident_active = 1
  AND (c.id IN (10,16,19,22)
  OR c.parent_id IN (10,16,19,22))
  AND c.category_visible = 1
GROUP BY i.id HAVING count(DISTINCT ic.category_id) = 
	(SELECT MAX(cnt) FROM (SELECT count(*) as cnt FROM category cx WHERE cx.id IN (10,16,19,22) GROUP BY cx.parent_id) AS m)
ORDER BY i.incident_title ASC

SELECT c1.parent_id, count(*)
FROM category c1
GROUP BY c1.parent_id
HAVING c1.parent_id <> 38
IN (SELECT c2.id FROM category c2 WHERE c2.parent_id = 38)

SELECT MAX(ctn) FROM (SELECT count(*) as ctn FROM category c WHERE c.id IN (10,16,19,22)
GROUP BY c.parent_id) AS m

SELECT c.parent_id, count(*) as ctn FROM category c WHERE c.id IN (10,16,19)
GROUP BY c.parent_id


SELECT DISTINCT i.id incident_id,
                i.incident_title,
                i.incident_description,
                i.incident_date,
                i.incident_mode,
                i.incident_active,
                i.incident_verified,
                i.location_id,
                l.country_id,
                l.location_name,
                l.latitude,
                l.longitude
FROM incident i
INNER JOIN LOCATION l ON (i.location_id = l.id)
INNER JOIN incident_category ic ON (ic.incident_id = i.id)
INNER JOIN category c ON (ic.category_id = c.id)
WHERE i.incident_active = 1
  AND (c.id IN (10,16,19,22)
       OR c.parent_id IN (10,16,19,22))
  AND c.category_visible = 1
GROUP BY i.id HAVING count(DISTINCT ic.category_id) =
  (SELECT COUNT(*)
   FROM
     (SELECT count(*)
      FROM category cx
      WHERE cx.id IN (10,16,19,22)
      GROUP BY cx.parent_id) AS mx)
ORDER BY i.incident_title ASC


SELECT DISTINCT i.id incident_id,
                i.incident_title,
                i.incident_description,
                i.incident_date,
                i.incident_mode,
                i.incident_active,
                i.incident_verified,
                i.location_id,
                l.country_id,
                l.location_name,
                l.latitude,
                l.longitude
FROM incident i
INNER JOIN LOCATION l ON (i.location_id = l.id)
INNER JOIN incident_category ic ON (ic.incident_id = i.id)
INNER JOIN category c ON (ic.category_id = c.id)
WHERE i.incident_active = 1
  AND (c.id IN (38)
       OR c.parent_id IN (38))
  AND c.category_visible = 1
GROUP BY i.id HAVING count(DISTINCT ic.category_id) =
  (SELECT COUNT(*)
   FROM
     (SELECT COUNT(*)
      FROM category cx
      WHERE cx.id IN (38)
      GROUP BY cx.parent_id) AS mx)
ORDER BY i.incident_title ASC


SELECT DISTINCT i.id incident_id,
                i.incident_title,
                i.incident_description,
                i.incident_date,
                i.incident_mode,
                i.incident_active,
                i.incident_verified,
                i.location_id,
                l.country_id,
                l.location_name,
                l.latitude,
                l.longitude
FROM incident i
INNER JOIN LOCATION l ON (i.location_id = l.id)
INNER JOIN incident_category ic ON (ic.incident_id = i.id)
INNER JOIN category c ON (ic.category_id = c.id)
WHERE i.incident_active = 1
  AND (c.id IN (19,
                16,
                38,
                10,
                17,
                22,
                24,
                14,
                7,
                30,
                15)
       OR c.parent_id IN (19,
                          16,
                          38,
                          10,
                          17,
                          22,
                          24,
                          14,
                          7,
                          30,
                          15))
  AND c.category_visible = 1
GROUP BY i.id HAVING count(DISTINCT ic.category_id) =
  (SELECT COUNT(*)
   FROM
     (SELECT COUNT(*)
      FROM category cx
      WHERE cx.id IN (19,
                      16,
                      38,
                      10,
                      17,
                      22,
                      24,
                      14,
                      7,
                      30,
                      15)
      GROUP BY cx.parent_id) AS mx)
ORDER BY i.incident_title ASC


SELECT cx.parent_id, COUNT(*)
  FROM category cx
  WHERE cx.id IN (19,
                  16,
                  38,
                  10,
                  17,
                  22,
                  24,
                  14,
                  7,
                  30,
                  15)
  AND cx.parent_id <> 0
  GROUP BY cx.parent_id;




