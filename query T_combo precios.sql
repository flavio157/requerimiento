select * from T_COMBO
select * from T_COMBO_ITEM

/*CM0005 ya no existe EST_PRODUCTO I*/
update T_PRODUCTO set EST_PRODUCTO = 'I' where COD_PRODUCTO = 'CM0005'
/*---------------*/


/*Combos que existen EST_PRODUCTO A*/
update T_PRODUCTO set EST_PRODUCTO = 'A' where COD_PRODUCTO = 'CM0001'
update T_PRODUCTO set EST_PRODUCTO = 'A' where COD_PRODUCTO = 'CM0002'
update T_PRODUCTO set EST_PRODUCTO = 'A' where COD_PRODUCTO = 'CM0003'
update T_PRODUCTO set EST_PRODUCTO = 'A' where COD_PRODUCTO = 'CM0004'
update T_PRODUCTO set EST_PRODUCTO = 'A' where COD_PRODUCTO = 'CM0006'
update T_PRODUCTO set EST_PRODUCTO = 'A' where COD_PRODUCTO = 'CM0007'
update T_PRODUCTO set EST_PRODUCTO = 'A' where COD_PRODUCTO = 'CM0008'
update T_PRODUCTO set EST_PRODUCTO = 'A' where COD_PRODUCTO = 'CM0009'
update T_PRODUCTO set EST_PRODUCTO = 'A' where COD_PRODUCTO = 'CM0010'
update T_PRODUCTO set EST_PRODUCTO = 'A' where COD_PRODUCTO = 'CM0011'
update T_PRODUCTO set EST_PRODUCTO = 'A' where COD_PRODUCTO = 'CM0012'
update T_PRODUCTO set EST_PRODUCTO = 'A' where COD_PRODUCTO = 'CM0013'
update T_PRODUCTO set EST_PRODUCTO = 'A' where COD_PRODUCTO = 'CM0014'
update T_PRODUCTO set EST_PRODUCTO = 'A' where COD_PRODUCTO = 'CM0015'
update T_PRODUCTO set EST_PRODUCTO = 'A' where COD_PRODUCTO = 'CM0016'
update T_PRODUCTO set EST_PRODUCTO = 'A' where COD_PRODUCTO = 'CM0017'
update T_PRODUCTO set EST_PRODUCTO = 'A' where COD_PRODUCTO = 'CM0018'
update T_PRODUCTO set EST_PRODUCTO = 'A' where COD_PRODUCTO = 'CM0019'
/*------------------*/

/*Actualizacion de los combos y sus precios*/
update T_COMBO set PRECIO = '95.00' where COD_COMBO = 'CM0001'	   /*CM0001 - REJUVENECEDOR*/
update T_COMBO set PRECIO = '140.00' where COD_COMBO = 'CM0002'   /*CM0002 - PROC.PLUS + SHAKER*/	
update T_COMBO set PRECIO = '140.00' where COD_COMBO = 'CM0003'	   /*CM0003 - PLUS+SHAKER+ISOMORE*/
update T_COMBO set PRECIO = '150.00' where COD_COMBO = 'CM0004'   /*CM0004 - VITA CLEAN+MAGNESIO*/
update T_COMBO set PRECIO = '120.00' where COD_COMBO = 'CM0006'	   /*CM0006 - BEATY PACK CON AROMA*/
update T_COMBO set PRECIO = '120.00' where COD_COMBO = 'CM0007'	   /*CM0007	- AROMATICO UNISEX*/
update T_COMBO set PRECIO = '120.00' where COD_COMBO = 'CM0008'	   /*CM0008 - ANTIARRUGAS*/
update T_COMBO set PRECIO = '130.00' where COD_COMBO = 'CM0009'	   /*CM0009 - PROCALAGEN + SHAKER*/
update T_COMBO set PRECIO = '130.00' where COD_COMBO = 'CM0010'   /* CM0010 Kollagen + shaker*/
update T_COMBO set PRECIO = '130.00' where COD_COMBO = 'CM0011'	   /*CM0011	- KOLL.UVAx600+SHAK*/
update T_COMBO set PRECIO = '130.00' where COD_COMBO = 'CM0012'	   /*CM0012	- ROCOLAGEN UVA + SHAKER*/
update T_COMBO set PRECIO = '150.00' where COD_COMBO = 'CM0013'	   /*CM0013	- COMBO GEL*/
update T_COMBO set PRECIO = '160.00' where COD_COMBO = 'CM0014'	   /*CM0014	- COMBO ALOE*/
update T_COMBO set PRECIO = '160.00' where COD_COMBO = 'CM0015'	   /*CM0015	- COMBO GIOVENTU*/
update T_COMBO set PRECIO = '190.00' where COD_COMBO = 'CM0016'	   /*CM0016	- COMBO PLUS BELLEZA*/
update T_COMBO set PRECIO = '160.00' where COD_COMBO = 'CM0017'   /*CM0017 - COMBO PLUS GIOVENTU*/
update T_COMBO set PRECIO = '160.00' where COD_COMBO = 'CM0018'	   /*CM0018 - COMBO PLUS ALOE*/		
update T_COMBO set PRECIO = '160.00' where COD_COMBO = 'CM0019'	   /*CM0019	- COMBO PLUS GEL*/
/*----------------*/




/*Combos y sus items actualizacion de precios*/
update T_COMBO_ITEM set PRECIO = '55.00' where COD_COMBO = 'CM0001'  and COD_PRODUCTO = '00472' /*CM0001 - REJUVENECEDOR    --  00472 - CP2-KOLLAGEN UVA X300*/
update T_COMBO_ITEM set PRECIO = '40.00' where COD_COMBO = 'CM0001' and COD_PRODUCTO = 'CO0003' /*CM0001 - REJUVENECEDOR  --  CO0003	CO3-GIOVENTU*/

update T_COMBO_ITEM set PRECIO = '60.00' where COD_COMBO = 'CM0002' and COD_PRODUCTO = '00481' /*CM0002 - PROC.PLUS + SHAKER -- 00481  SHAKER GYM */
update T_COMBO_ITEM set PRECIO = '80.00' where COD_COMBO = 'CM0002' and COD_PRODUCTO = '00457' /*CM0002 - PROC.PLUS + SHAKER --- 00457	BP9 PROCOL.PLUS N.X600*/

update T_COMBO_ITEM set PRECIO = '40.00' where COD_COMBO = 'CM0003' and COD_PRODUCTO = '00481' /*CM0003 - PLUS+SHAKER+ISOMORE -- 00481	SHAKER GYM*/
update T_COMBO_ITEM set PRECIO = '60.00' where COD_COMBO = 'CM0003' and COD_PRODUCTO = '00518' /*CM0003 - PLUS+SHAKER+ISOMORE -- 00518	CP9 COLAG.PLUS NAR X150*/
update T_COMBO_ITEM set PRECIO = '40.00' where COD_COMBO = 'CM0003' and COD_PRODUCTO = '00459' /*CM0003 - PLUS+SHAKER+ISOMORE -- 00459	BP8-ISO MORE ENERGY 1KL*/

update T_COMBO_ITEM set PRECIO = '90.00' where COD_COMBO = 'CM0004'  and COD_PRODUCTO = '00427' /*CM0004 - VITA CLEAN+MAGNESIO - 00427	AP4-VITACLEAN X600*/
update T_COMBO_ITEM set PRECIO = '60.00' where COD_COMBO = 'CM0004'  and COD_PRODUCTO = '00455' /*CM0004 - VITA CLEAN+MAGNESIO - 00455	MAGNESIO 140 GRS*/

update T_COMBO_ITEM set PRECIO = '40.00' where COD_COMBO = 'CM0006' and COD_PRODUCTO = 'CO0001' /*CM0006 - BEATY PACK CON AROMA - CO0001 CO1-PLUS JEUNE*/
update T_COMBO_ITEM set PRECIO = '40.00' where COD_COMBO = 'CM0006' and COD_PRODUCTO = 'CO0002' /*CM0006 - BEATY PACK CON AROMA - CO0002 CO2-ALOE EXFOLIANT*/
update T_COMBO_ITEM set PRECIO = '40.00' where COD_COMBO = 'CM0006' and COD_PRODUCTO = 'CO0005' /*CM0006 - BEATY PACK CON AROMA - CO0005 CO5-DELICAT*/	


update T_COMBO_ITEM set PRECIO = '40.00' where COD_COMBO = 'CM0007' and COD_PRODUCTO = 'CO0002'  /*CM0007 - AROMATICO UNISEX - CO0002  CO2-ALOE EXFOLIANT*/
update T_COMBO_ITEM set PRECIO = '40.00' where COD_COMBO = 'CM0007' and COD_PRODUCTO = 'CO0004'  /*CM0007 - AROMATICO UNISEX - CO0004  CO4-HOMME DE FER*/
update T_COMBO_ITEM set PRECIO = '40.00' where COD_COMBO = 'CM0007'  and COD_PRODUCTO = 'CO0005' /*CM0007 - AROMATICO UNISEX - CO0005  CO5-DELICAT*/	

update T_COMBO_ITEM set PRECIO = '40.00' where COD_COMBO = 'CM0008'  and COD_PRODUCTO = 'CO0001' /*CM0008 - ANTIARRUGAS - CO0001	CO1-PLUS JEUNE*/
update T_COMBO_ITEM set PRECIO = '40.00' where COD_COMBO = 'CM0008'  and COD_PRODUCTO = 'CO0002' /*CM0008 - ANTIARRUGAS - CO0002	CO2-ALOE EXFOLIANT*/
update T_COMBO_ITEM set PRECIO = '40.00' where COD_COMBO = 'CM0008'  and COD_PRODUCTO = 'CO0003' /*CM0008 - ANTIARRUGAS - CO0003	CO3-GIOVENTU*/


update T_COMBO_ITEM set PRECIO = '30.00' where COD_COMBO = 'CM0009'  and COD_PRODUCTO = '00479' /*CM0009 - PROCALAGEN + SHAKER - 00479	SHAKER KIDS*/
update T_COMBO_ITEM set PRECIO = '100.00' where COD_COMBO = 'CM0009'  and COD_PRODUCTO = '00424' /*CM0009 - PROCALAGEN + SHAKER - 00424	AP1-PROCOLAGEN NAR .X600*/

update T_COMBO_ITEM set PRECIO = '30.00' where COD_COMBO = 'CM0010'  and COD_PRODUCTO = '00479' /*CM0010 Kollagen + shaker - 00479	SHAKER KIDS*/
update T_COMBO_ITEM set PRECIO = '100.00' where COD_COMBO = 'CM0010'  and COD_PRODUCTO = '00431' /*CM0010 Kollagen + shaker - 00431	AP8-KOLLAGEN NARAN.X600*/


update T_COMBO_ITEM set PRECIO = '100.00' where COD_COMBO = 'CM0011'  and COD_PRODUCTO = '00436' /*CM0011- KOLL.UVAx600+SHAK - 00436	BP4-KOLLAGEN UVA X600*/
update T_COMBO_ITEM set PRECIO = '30.00' where COD_COMBO = 'CM0011'  and COD_PRODUCTO = '00478' /*CM0011- KOLL.UVAx600+SHAK - 00478	SHAKER SPORT*/

update T_COMBO_ITEM set PRECIO = '30.00' where COD_COMBO = 'CM0012'  and COD_PRODUCTO = '00479' /*CM0012 - ROCOLAGEN UVA + SHAKER - 00479	SHAKER KIDS*/
update T_COMBO_ITEM set PRECIO = '100.00' where COD_COMBO = 'CM0012'  and COD_PRODUCTO = '00429' /*CM0012 - ROCOLAGEN UVA + SHAKER - 00429 AP6-PROCOLAGEN UVA X600*/

update T_COMBO_ITEM set PRECIO = '40.00' where COD_COMBO = 'CM0013'  and COD_PRODUCTO = 'CO0001' /*CM0013 - COMBO GEL - CO0001 CO1-PLUS JEUNE*/
update T_COMBO_ITEM set PRECIO = '110.00' where COD_COMBO = 'CM0013'  and COD_PRODUCTO = '00431' /*CM0013 - COMBO GEL - 00431	AP8-KOLLAGEN NARAN.X600*/

update T_COMBO_ITEM set PRECIO = '50.00' where COD_COMBO = 'CM0014'  and COD_PRODUCTO = 'CO0002' /*CM0014 - COMBO ALOE - CO0002	CO2-ALOE EXFOLIANT*/
update T_COMBO_ITEM set PRECIO = '110.00' where COD_COMBO = 'CM0014'  and COD_PRODUCTO = '00431' /*CM0014 - COMBO ALOE - 00431	AP8-KOLLAGEN NARAN.X600*/

update T_COMBO_ITEM set PRECIO = '50.00' where COD_COMBO = 'CM0015'  and COD_PRODUCTO = 'CO0003' /*CM0015 - COMBO GIOVENTU - CO0003	CO3-GIOVENTU*/
update T_COMBO_ITEM set PRECIO = '110.00' where COD_COMBO = 'CM0015'  and COD_PRODUCTO = '00431' /*CM0015 - COMBO GIOVENTU - 00431	AP8-KOLLAGEN NARAN.X600*/

update T_COMBO_ITEM set PRECIO = '50.00' where COD_COMBO = 'CM0016'  and COD_PRODUCTO = 'CO0001' /*CM0016 - COMBO PLUS BELLEZA - CO0001 CO1-PLUS JEUNE*/
update T_COMBO_ITEM set PRECIO = '30.00' where COD_COMBO = 'CM0016'  and COD_PRODUCTO = 'CO0002' /*CM0016 - COMBO PLUS BELLEZA - CO0002 CO2-ALOE EXFOLIANT*/
update T_COMBO_ITEM set PRECIO = '110.00' where COD_COMBO = 'CM0016'  and COD_PRODUCTO = '00457' /*CM0016 - COMBO PLUS BELLEZA - 00457	BP9 PROCOL.PLUS N.X600*/

update T_COMBO_ITEM set PRECIO = '50.00' where COD_COMBO = 'CM0017'  and COD_PRODUCTO = 'CO0003' /*CM0017 - COMBO PLUS GIOVENTU - CO0003 CO3-GIOVENTU*/
update T_COMBO_ITEM set PRECIO = '110.00' where COD_COMBO = 'CM0017'  and COD_PRODUCTO = '00457' /*CM0017 - COMBO PLUS GIOVENTU - 00457	BP9 PROCOL.PLUS N.X600*/

update T_COMBO_ITEM set PRECIO = '40.00' where COD_COMBO = 'CM0018'  and COD_PRODUCTO = 'CO0002' /*CM0018 - COMBO PLUS ALOE - CO0002 CO2-ALOE EXFOLIANT*/	
update T_COMBO_ITEM set PRECIO = '120.00' where COD_COMBO = 'CM0018'  and COD_PRODUCTO = '00457' /*CM0018 - COMBO PLUS ALOE - 00457 BP9 PROCOL.PLUS N.X600*/	

update T_COMBO_ITEM set PRECIO = '50.00' where COD_COMBO = 'CM0019'  and COD_PRODUCTO = 'CO0001'  /*CM0019	- COMBO PLUS GEL - CO0001 CO1-PLUS JEUNE*/
update T_COMBO_ITEM set PRECIO = '110.00' where COD_COMBO = 'CM0019'  and COD_PRODUCTO = '00457'  /*CM0019	- COMBO PLUS GEL - 00457 BP9 PROCOL.PLUS N.X600*/
/*-----------------------------*/



insert into T_COMBO (COD_COMBO,USU_REGISTRO,PRECIO,CANTIDAD) values ('CM0020',NULL,'160',NULL)
insert into T_COMBO (COD_COMBO,USU_REGISTRO,PRECIO,CANTIDAD) values ('CM0021',NULL,'190',NULL)

/*Procolagen plus + plus jeaun*/
insert into T_COMBO_ITEM (COD_COMBO,COD_PRODUCTO,PRECIO) values ('CM0020','00457','100.00')
insert into T_COMBO_ITEM (COD_COMBO,COD_PRODUCTO,PRECIO) values ('CM0020','CO0001','60.00')

/*procolagen plus + plus jean + ALOE*/
insert into T_COMBO_ITEM (COD_COMBO,COD_PRODUCTO,PRECIO) values ('CM0021','00457','110.00')
insert into T_COMBO_ITEM (COD_COMBO,COD_PRODUCTO,PRECIO) values ('CM0021','CO0001','40.00')
insert into T_COMBO_ITEM (COD_COMBO,COD_PRODUCTO,PRECIO) values ('CM0021','CO0002','40.00')












