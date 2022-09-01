declare @filename varchar(255)
set @filename = '/var/www/bbmnew/backup/' + convert(varchar,convert(date,getdate())) + '.bak' 
backup database bbmpalembang to disk=@filename