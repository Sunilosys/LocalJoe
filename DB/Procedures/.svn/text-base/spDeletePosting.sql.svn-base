DELIMITER @@
DROP PROCEDURE IF EXISTS spDeletePosting;
CREATE PROCEDURE spDeletePosting(in i_posting_id int)
begin
  --
  delete from posting_attribute where posting_id = i_posting_id;
  delete from posting_image where posting_id = i_posting_id;
  delete from posting_tag where posting_id = i_posting_id;
  delete from posting_view where posting_id = i_posting_id;
  delete from posting where posting_id = i_posting_id;
  --
END @@
DELIMITER ;

