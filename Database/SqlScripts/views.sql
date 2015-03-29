CREATE VIEW schedule_secs AS
SELECT *
FROM section_days JOIN sche_sec_rel
WHERE section_days.sectionId = sche_sec_rel.section_id;
