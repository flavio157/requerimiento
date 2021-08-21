USE [Almacenes]
GO
/****** Object:  Table [dbo].[T_USUARIO_CALL]    Script Date: 08/21/2021 12:43:47 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[T_USUARIO_CALL](
	[COD_USUARIO] [char](3) NULL,
	[NOM_USUARIO] [varchar](30) NULL,
	[PDW_USUARIO] [char](6) NULL,
	[ANEXO_USUARIO] [char](4) NULL,
	[EST_USUARIO] [char](1) NULL,
	[EST_INGRESO] [char](1) NULL,
	[OFICINA] [char](30) NULL,
	[COD_PERSONAL] [char](5) NULL,
	[ZONA] [char](1) NULL
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[T_TMP_GASTO_ITEM]    Script Date: 08/21/2021 12:43:47 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[T_TMP_GASTO_ITEM](
	[CODIGO] [char](9) NULL,
	[COD_PRODUCTO] [char](6) NULL,
	[CAN_PRODUCTO] [int] NULL,
	[PREC_PRODUCTO] [numeric](7, 3) NULL
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[T_TMP_GASTO]    Script Date: 08/21/2021 12:43:47 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[T_TMP_GASTO](
	[CODIGO] [char](9) NULL,
	[OFICINA] [char](5) NULL,
	[FEC_EMISION] [datetime] NULL,
	[COD_PERSONAL] [char](5) NULL,
	[TIPO_COMPROBANTE] [char](1) NULL,
	[SERIE_CONTABILIDAD] [char](4) NULL,
	[COMP_CONTABILIDAD] [char](14) NULL,
	[IDENTIFICACION] [char](11) NULL,
	[COD_PROVEEDOR] [char](5) NULL,
	[NOMBRE] [varchar](100) NULL,
	[DIRECCION] [varchar](200) NULL,
	[OBS_COMPROBANTE] [char](100) NULL,
	[MONTO_COMPROBANTE] [numeric](7, 2) NULL,
	[MONTO_MODIFICADO] [numeric](7, 2) NULL,
	[NRO_CORRELATIVO] [char](9) NULL,
	[USU_REGISTRO] [char](5) NULL,
	[CAJA] [char](1) NULL,
	[CONTABILIDAD] [char](1) NULL,
	[COD_EMPRESA] [char](5) NULL,
	[COD_CONCEPTO_CAJA] [char](5) NULL
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[T_SUB_MENUS]    Script Date: 08/21/2021 12:43:47 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[T_SUB_MENUS](
	[ID] [int] IDENTITY(1,1) NOT NULL,
	[ID_MENU] [char](3) NULL,
	[ID_SUBMENU1] [char](3) NULL,
	[SUB_NOMBRE1] [varchar](100) NULL,
	[URL1] [varchar](100) NULL,
	[IDSUBMENU1] [char](3) NULL,
	[IDSUBMENU2] [char](3) NULL,
	[SUB_NOMBRE2] [varchar](100) NULL,
	[URL2] [varchar](100) NULL,
	[ESTADO1] [char](1) NULL,
	[ESTADO2] [char](1) NULL
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[T_PUNTOPARTIDA]    Script Date: 08/21/2021 12:43:47 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[T_PUNTOPARTIDA](
	[ID] [int] IDENTITY(1,1) NOT NULL,
	[LATITUD] [decimal](9, 7) NULL,
	[LONGITUD] [decimal](9, 7) NULL,
	[COD_ZONA] [char](5) NULL,
	[OFICINA] [char](5) NULL
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[T_PROVEEDOR]    Script Date: 08/21/2021 12:43:47 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[T_PROVEEDOR](
	[COD_PROVEEDOR] [char](5) NULL,
	[NOM_PROVEEDOR] [varchar](50) NULL,
	[DIR_PROVEEDOR] [varchar](100) NULL,
	[RUC_PROVEEDOR] [char](11) NULL,
	[DNI_PROVEEDOR] [char](8) NULL,
	[COD_BANCO] [char](3) NULL,
	[CUENTA_PROVEEDOR] [char](18) NULL,
	[CONTACTO_PROVEEDOR] [varchar](50) NULL,
	[TEL_PROVEEDOR] [char](9) NULL,
	[CEL_PROVEEDOR] [char](9) NULL,
	[CEL_CONTACTO] [char](9) NULL,
	[CORREO_PROVEEDOR] [varchar](50) NULL,
	[EST_PROVEEDOR] [char](1) NULL,
	[USU_REGISTRO] [datetime] NULL,
	[FEC_REGISTRO] [datetime] NULL,
	[USU_MODIFICO] [varchar](30) NULL,
	[FEC_MODIFICO] [datetime] NULL,
	[MAQUINA] [varchar](50) NULL
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[T_PRODUCTOS_REGALO]    Script Date: 08/21/2021 12:43:47 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[T_PRODUCTOS_REGALO](
	[ID] [int] IDENTITY(1,1) NOT NULL,
	[UNIDAD_MEDIDA] [char](10) NULL,
	[CANTIDAD] [int] NULL,
	[REGALO_UNIDAD_MEDIDA] [char](10) NULL,
	[REGALO_DOS] [char](10) NULL,
	[CANTIDAD_REGALO_UNO] [int] NULL,
	[CANTIDAD_REGALO_DOS] [int] NULL,
	[ESTADO] [char](1) NULL,
	[ZONA] [char](1) NULL
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[T_PRODUCTO_PRECIO]    Script Date: 08/21/2021 12:43:47 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[T_PRODUCTO_PRECIO](
	[COD_PRODUCTO] [nvarchar](255) NULL,
	[ZONA] [nvarchar](255) NULL,
	[CANTIDAD] [nvarchar](255) NULL,
	[BONO] [nvarchar](255) NULL,
	[PRECIO] [nvarchar](255) NULL
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[T_PRODUCTO]    Script Date: 08/21/2021 12:43:47 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[T_PRODUCTO](
	[COD_PRODUCTO] [nvarchar](255) NULL,
	[COD_CATEGORIA] [nvarchar](255) NULL,
	[DES_PRODUCTO] [nvarchar](255) NULL,
	[UNI_MEDIDA] [nvarchar](255) NULL,
	[STOCK_MINIMO] [nvarchar](255) NULL,
	[ABR_PRODUCTO] [nvarchar](255) NULL,
	[PRE_PRODUCTO] [nvarchar](255) NULL,
	[EST_PRODUCTO] [nvarchar](255) NULL,
	[USU_REGISTRO] [nvarchar](255) NULL,
	[FEC_REGISTRO] [nvarchar](255) NULL,
	[USU_MODIFICO] [nvarchar](255) NULL,
	[FEC_MODIFICO] [nvarchar](255) NULL,
	[MAQUINA] [nvarchar](255) NULL,
	[COMPRA] [nvarchar](255) NULL,
	[COD_EMPRESA] [nvarchar](255) NULL,
	[EXTERNO] [nvarchar](255) NULL,
	[COD_CONTABLE] [nvarchar](255) NULL,
	[PRECIO_WEB] [nvarchar](255) NULL,
	[PRECIO_NORTE] [nvarchar](255) NULL,
	[PRECIO_SUR] [nvarchar](255) NULL,
	[CANTIDAD] [nvarchar](255) NULL,
	[PESO_NETO] [int] NULL
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[T_POLITICA_PRECIOS]    Script Date: 08/21/2021 12:43:47 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[T_POLITICA_PRECIOS](
	[CODIGO] [nvarchar](255) NULL,
	[CANTIDAD] [nvarchar](255) NULL,
	[BONO] [nvarchar](255) NULL,
	[COD_USUARIO] [nvarchar](255) NULL,
	[FECHA] [nvarchar](255) NULL,
	[ESTADO] [nvarchar](255) NULL,
	[CANT_FIN] [nvarchar](255) NULL
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[T_PERSONAL_ENFALTA]    Script Date: 08/21/2021 12:43:47 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[T_PERSONAL_ENFALTA](
	[ID] [int] IDENTITY(1,1) NOT NULL,
	[FECH_REGISTRO] [datetime] NULL,
	[COD_PERSONAL] [char](5) NULL,
	[NOM_PERSONAL] [varchar](60) NULL,
	[PROMEDIO] [numeric](7, 2) NULL,
	[OFICINA] [char](30) NULL
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[T_PERSONAL]    Script Date: 08/21/2021 12:43:47 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[T_PERSONAL](
	[COD_PERSONAL] [char](5) NULL,
	[COD_AREA] [char](5) NULL,
	[COD_CARGO] [char](5) NULL,
	[TIP_AGRUPADO] [char](3) NULL,
	[DNI_PERSONAL] [char](8) NULL,
	[NOM_PERSONAL1] [varchar](60) NULL,
	[NOM_PERSONAL2] [varchar](30) NULL,
	[APE_PPERSONAL] [varchar](30) NULL,
	[APE_MPERSONAL] [varchar](30) NULL,
	[SAL_BASICO] [decimal](9, 2) NULL,
	[COMISIONES] [decimal](7, 2) NULL,
	[DIR_PERSONAL] [varchar](100) NULL,
	[COD_DEPARTAMENTO] [char](5) NULL,
	[COD_PROVINCIA] [char](5) NULL,
	[COD_DISTRITO] [char](5) NULL,
	[TEL_PERSONAL] [decimal](11, 0) NULL,
	[CEL_PERSONAL] [decimal](11, 0) NULL,
	[EST_PERSONAL] [char](1) NULL,
	[COD_SUPERVISOR] [char](5) NULL,
	[COD_ZONA] [char](5) NULL,
	[FEC_INGRESO] [datetime] NULL,
	[USU_REGISTRO] [varchar](30) NULL,
	[FEC_REGISTRO] [datetime] NULL,
	[USU_MODIFICO] [varchar](30) NULL,
	[FEC_MODIFICO] [datetime] NULL,
	[GRUPO] [char](1) NULL,
	[POR_INICIAL] [char](1) NULL,
	[NPAGO] [char](1) NULL,
	[NCONTRATOS] [numeric](7, 2) NULL,
	[PRODUCCION] [char](1) NULL,
	[SANC_CAJA] [char](1) NULL,
	[SANC_MERCA] [char](1) NULL,
	[SANC_COBRA] [char](1) NULL,
	[IDENTIFICADOR] [char](1) NULL,
	[N_CUENTA] [char](14) NULL,
	[TITULAR] [varchar](50) NULL,
	[OCURRENCIA] [char](1) NULL,
	[LIMPIEZA] [char](1) NULL,
	[AFP] [varchar](18) NULL,
	[CUOTA] [numeric](7, 2) NULL
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[T_PERMISOS]    Script Date: 08/21/2021 12:43:47 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[T_PERMISOS](
	[ID] [int] IDENTITY(1,1) NOT NULL,
	[ANEXO] [char](4) NULL,
	[MENU] [char](3) NULL,
	[SUB_MENU1] [char](3) NULL,
	[SUB_MENU2] [char](3) NULL
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[T_PARAMETRO]    Script Date: 08/21/2021 12:43:47 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[T_PARAMETRO](
	[ID] [int] IDENTITY(1,1) NOT NULL,
	[TIEMPO_RESET] [varchar](5) NULL
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[T_OFICINAS]    Script Date: 08/21/2021 12:43:47 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[T_OFICINAS](
	[ID] [int] IDENTITY(1,1) NOT NULL,
	[OFICINA] [varchar](100) NULL
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[T_LATLNG]    Script Date: 08/21/2021 12:43:47 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[T_LATLNG](
	[ID] [int] IDENTITY(1,1) NOT NULL,
	[NUM_CONTRATO] [char](9) NULL,
	[LATITUD] [decimal](9, 7) NULL,
	[LONGITUD] [decimal](9, 7) NULL,
	[USUARIO] [char](5) NULL,
	[OBSERVACION] [varchar](100) NULL,
	[DIRECCION] [varchar](100) NULL,
	[FECHA] [datetime] NULL
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[T_IMAGEN]    Script Date: 08/21/2021 12:43:47 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[T_IMAGEN](
	[ID] [int] IDENTITY(1,1) NOT NULL,
	[CODIGO] [char](50) NULL,
	[IMAGEN] [image] NULL
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[T_FAMILIA]    Script Date: 08/21/2021 12:43:47 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[T_FAMILIA](
	[COD_FAMILIA] [char](3) NULL,
	[DES_FAMILIA] [varchar](50) NULL,
	[EST_FAMILIA] [char](1) NULL
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[T_EMPRESA]    Script Date: 08/21/2021 12:43:47 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[T_EMPRESA](
	[COD_EMPRESA] [char](5) NULL,
	[NOMBRE] [varchar](100) NULL,
	[DIRECCION] [varchar](100) NULL,
	[RUC] [char](11) NULL,
	[ESTADO] [char](1) NULL
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[T_CONCEPTO_MOVIMIENTO]    Script Date: 08/21/2021 12:43:47 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[T_CONCEPTO_MOVIMIENTO](
	[COD_CONCEPTOCAJA] [char](5) NULL,
	[DES_CONCEPTOCAJA] [char](100) NULL,
	[EST_CONCEPTOCAJA] [char](1) NULL,
	[USU_REGISTRO] [varchar](30) NULL,
	[FEC_REGISTRO] [datetime] NULL,
	[USU_MODIFICO] [varchar](30) NULL,
	[FEC_MODIFICO] [datetime] NULL,
	[CAJA] [char](1) NULL
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[T_COMBO_ITEM]    Script Date: 08/21/2021 12:43:47 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[T_COMBO_ITEM](
	[COD_COMBO] [char](6) NULL,
	[COD_PRODUCTO] [char](6) NULL,
	[PRECIO] [numeric](7, 2) NULL
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[T_COMBO]    Script Date: 08/21/2021 12:43:47 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[T_COMBO](
	[COD_COMBO] [char](6) NULL,
	[USU_REGISTRO] [char](5) NULL,
	[PRECIO] [numeric](7, 2) NULL,
	[CANTIDAD] [int] NULL
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[T_CATEGORIA]    Script Date: 08/21/2021 12:43:47 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[T_CATEGORIA](
	[COD_CATEGORIA] [char](5) NULL,
	[DES_CATEGORIA] [varchar](50) NULL,
	[COD_FAMILIA] [char](3) NULL,
	[EST_CATEGORIA] [char](1) NULL,
	[USU_REGISTRO] [varchar](30) NULL,
	[FEC_REGISTRO] [datetime] NULL,
	[USU_MODIFICO] [varchar](30) NULL,
	[FEC_MODIFICO] [datetime] NULL,
	[MAQUINA] [varchar](50) NULL
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[T_CALL_EMPADRONADORA]    Script Date: 08/21/2021 12:43:47 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[T_CALL_EMPADRONADORA](
	[CODIGO] [numeric](18, 0) NULL,
	[DNI] [char](8) NULL,
	[NOMBRE] [varchar](100) NULL,
	[DIRECCION] [varchar](100) NULL,
	[TELEFONO] [char](9) NULL,
	[EST_LLAMADA] [char](1) NULL,
	[OK_EMPADRONADORA] [char](1) NULL,
	[OFICINA] [char](30) NULL,
	[COD_EMPADRONADORA] [char](5) NULL,
	[COD_REGISTRO] [char](5) NULL,
	[FEC_REGISTRO] [datetime] NULL,
	[COD_PERSONAL] [char](5) NULL,
	[FEC_OK] [char](10) NULL,
	[EQUIPO] [varchar](50) NULL,
	[COMENTARIO] [varchar](200) NULL,
	[COD_EMPADRO] [char](8) NULL,
	[PROX_LLAMADA] [datetime] NULL,
	[IDENTIFICADOR] [char](15) NULL,
	[HORA] [char](8) NULL,
	[COD_OPERADORA] [char](5) NULL,
	[FEC_OPERADORA] [datetime] NULL,
	[COD_DISTRITO] [char](5) NULL,
	[OK_OPERADORA] [char](1) NULL,
	[PROX_OPERADORA] [datetime] NULL,
	[SITUACION] [char](1) NULL,
	[EDAD] [int] NULL,
	[PESO] [numeric](7, 2) NULL,
	[TALLA] [numeric](7, 2) NULL,
	[IMC] [numeric](7, 2) NULL,
	[GRASA] [decimal](7, 2) NULL,
	[AGUA] [decimal](7, 2) NULL,
	[LLAMADA] [int] NULL,
	[OFI_OPERADORA] [char](5) NULL,
	[HORA_OPERADORA] [char](10) NULL
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[T_CALL_CENTER_ITEM]    Script Date: 08/21/2021 12:43:47 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[T_CALL_CENTER_ITEM](
	[CODIGO] [numeric](18, 0) NULL,
	[NUM_CONTRATO] [char](9) NULL,
	[COD_PRODUCTO] [char](6) NULL,
	[NUM_LOTE] [char](10) NULL,
	[PRECIO] [numeric](7, 2) NULL,
	[OFICINA] [char](30) NULL
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[T_CALL_CENTER]    Script Date: 08/21/2021 12:43:47 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[T_CALL_CENTER](
	[CODIGO] [nvarchar](255) NULL,
	[NUM_CONTRATO] [nvarchar](255) NULL,
	[NOMBRE] [nvarchar](255) NULL,
	[DIRECCION] [nvarchar](255) NULL,
	[TELEFONO] [nvarchar](255) NULL,
	[EST_LLAMADA] [nvarchar](255) NULL,
	[OK_CONTRATO] [nvarchar](255) NULL,
	[OFICINA] [nvarchar](255) NULL,
	[FEC_OK] [nvarchar](255) NULL,
	[COD_PERSONAL] [nvarchar](255) NULL,
	[IDENTIFICACION] [nvarchar](255) NULL,
	[COD_REGISTRO] [nvarchar](255) NULL,
	[FEC_REGISTRO] [nvarchar](255) NULL,
	[EQUIPO] [nvarchar](255) NULL,
	[COD_DISTRITO] [nvarchar](255) NULL,
	[CUOTAS] [nvarchar](255) NULL,
	[COMENTARIO] [nvarchar](255) NULL,
	[DESPRODUCTOS] [nvarchar](255) NULL,
	[MON_INICIAL] [decimal](7, 2) NULL,
	[FEC_GENERADO] [date] NULL,
	[COD_VENDEDOR] [nvarchar](255) NULL,
	[COD_ZONA] [nvarchar](255) NULL,
	[REFERENCIA] [nvarchar](255) NULL,
	[COD_CLIENTE] [nvarchar](255) NULL,
	[FEC_COBRO] [nvarchar](255) NULL,
	[TELEFONO2] [nvarchar](255) NULL
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[T_CAB_MENU]    Script Date: 08/21/2021 12:43:47 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[T_CAB_MENU](
	[ID_MENU] [char](3) NULL,
	[NOMBRE] [varchar](100) NULL,
	[URL] [varchar](100) NULL,
	[ESTADO] [char](1) NULL
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[T_ASISTENCIAS]    Script Date: 08/21/2021 12:43:47 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[T_ASISTENCIAS](
	[CODIGO] [decimal](18, 0) IDENTITY(1,1) NOT NULL,
	[FECHA] [datetime] NULL,
	[COD_PERSONAL] [char](5) NULL,
	[HORA_INGRESO] [char](8) NULL,
	[HORA_SALIDA] [char](8) NULL,
	[TIPO_PERSONAL] [char](1) NULL,
	[MAQUINA] [varchar](50) NULL,
	[ACCION] [char](1) NULL,
	[ING_PROGRAMADO] [char](7) NULL,
	[SAL_PROGRAMADO] [char](8) NULL,
	[ACTUALIZACION] [char](4) NULL
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[T_ALMACEN_PRODUCTOS]    Script Date: 08/21/2021 12:43:47 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[T_ALMACEN_PRODUCTOS](
	[COD_INGRESO] [char](9) NULL,
	[COD_PRODUCTO] [char](6) NULL,
	[COD_ALMACEN] [char](5) NULL,
	[COD_PRODUCCION] [char](9) NULL,
	[NUM_LOTE] [char](9) NULL,
	[NUM_CONTRATO] [char](9) NULL,
	[COD_GUIA] [char](9) NULL,
	[FEC_INGRESO] [datetime] NULL,
	[FEC_SALIDA] [datetime] NULL,
	[FEC_VENCIMIENTO] [datetime] NULL,
	[EST_DET_PRODUCTO] [char](1) NULL,
	[N_CAJA] [numeric](9, 0) NULL,
	[EST_CAJA] [char](1) NULL,
	[CONFIRMACION] [char](1) NULL,
	[COD_CONFIRMACION] [char](5) NULL,
	[FEC_CONFIRMACION] [datetime] NULL,
	[FEC_MOVIMIENTO] [datetime] NULL,
	[PRECIO] [numeric](18, 0) NULL,
	[COBRADO] [numeric](18, 0) NULL,
	[COD_PERSONAL] [char](6) NULL,
	[FEC_EMISION] [datetime] NULL,
	[OBSERVACION] [varchar](50) NULL,
	[PROVEEDOR] [char](1) NULL,
	[FEC_PISTOLEO] [datetime] NULL,
	[INTERNO] [char](1) NULL
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[T_ADMINISTRADORES]    Script Date: 08/21/2021 12:43:47 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[T_ADMINISTRADORES](
	[COD_USUARIO] [char](3) NULL,
	[NOM_USUARIO] [varchar](30) NULL,
	[COD_PERSONAL] [char](5) NULL
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[CDR]    Script Date: 08/21/2021 12:43:47 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[CDR](
	[calldate] [datetime] NULL,
	[clid] [varchar](80) NULL,
	[src] [varchar](80) NULL,
	[dst] [varchar](80) NULL,
	[dcontext] [varchar](80) NULL,
	[channel] [varchar](80) NULL,
	[dstchannel] [varchar](80) NULL,
	[lastapp] [varchar](80) NULL,
	[lastdata] [varchar](80) NULL,
	[duration] [int] NULL,
	[bilsec] [int] NULL,
	[disposition] [varchar](45) NULL,
	[amaflags] [int] NULL,
	[accountcode] [varchar](20) NULL,
	[uniqueid] [varchar](150) NULL,
	[userfield] [varchar](225) NULL
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  View [dbo].[V_MOSTRAR_PEDIDO]    Script Date: 08/21/2021 12:43:48 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
create view [dbo].[V_MOSTRAR_PEDIDO]
as
select CODIGO ,CLIENTE,NUM_CONTRATO ,COD_VENDEDORA, FECHA from T_PPEDIDO
GO
/****** Object:  Table [dbo].[android]    Script Date: 08/21/2021 12:43:47 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[android](
	[Latitud] [varchar](10) NULL,
	[Longitud] [varchar](10) NULL,
	[Bateria] [int] NULL,
	[cod_personal] [varchar](5) NULL,
	[fecha] [datetime] NULL
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  View [dbo].[borrar]    Script Date: 08/21/2021 12:43:48 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE view [dbo].[borrar]
as
SELECT * FROM T_PERSONAL where COD_AREA = '00003' and EST_PERSONAL = 'A'
GO
/****** Object:  View [dbo].[V_VERIFICAR_CUOTAPERSONAL]    Script Date: 08/21/2021 12:43:48 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
create view [dbo].[V_VERIFICAR_CUOTAPERSONAL]
as
select * from  T_PERSONAL
GO
/****** Object:  View [dbo].[V_PRODUCTO_REGALO]    Script Date: 08/21/2021 12:43:48 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE view [dbo].[V_PRODUCTO_REGALO]
as
select * from T_PRODUCTOS_REGALO where ESTADO = '1'
GO
/****** Object:  View [dbo].[V_POLITICA_PRECIOS]    Script Date: 08/21/2021 12:43:48 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE view [dbo].[V_POLITICA_PRECIOS]
as
SELECT * FROM T_PRODUCTO_PRECIO
GO
/****** Object:  View [dbo].[V_POLITICA_BONOS]    Script Date: 08/21/2021 12:43:48 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
create VIEW [dbo].[V_POLITICA_BONOS]
as
select * from T_PRODUCTO_PRECIO
GO
/****** Object:  View [dbo].[V_MOSTRAR_PEDIDO_ITEM]    Script Date: 08/21/2021 12:43:48 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
create view [dbo].[V_MOSTRAR_PEDIDO_ITEM]
as
select pc.CODIGO,pc.COD_PRODUCTO, p.ABR_PRODUCTO,p.DES_PRODUCTO,pc.CANTIDAD ,pc.precio from T_PPEDIDO_CANTIDAD as pc
inner join T_PRODUCTO as p
on pc.COD_PRODUCTO =  p.COD_PRODUCTO
GO
/****** Object:  View [dbo].[V_LOGIN]    Script Date: 08/21/2021 12:43:48 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
create view [dbo].[V_LOGIN]
as
SELECT COD_USUARIO, NOM_USUARIO, 
PDW_USUARIO, ANEXO_USUARIO, 
EST_USUARIO, EST_INGRESO, 
OFICINA, COD_PERSONAL, ZONA
FROM dbo.T_USUARIO_CALL where EST_USUARIO != 'A'
GO
/****** Object:  View [dbo].[V_LLAMADA_PENDIENTE]    Script Date: 08/21/2021 12:43:48 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE view [dbo].[V_LLAMADA_PENDIENTE]
as
select * from T_CALL_EMPADRONADORA where PROX_OPERADORA is not null and PROX_LLAMADA <= GETDATE()
and HORA_OPERADORA is not null
GO
/****** Object:  View [dbo].[V_COMBOPRODUCTO]    Script Date: 08/21/2021 12:43:48 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE view [dbo].[V_COMBOPRODUCTO]
as 
select c.COD_COMBO as combo,p.COD_PRODUCTO as cod_producto,p.DES_PRODUCTO as nombre,
c.PRECIO as precio from T_PRODUCTO as p
inner join T_COMBO_ITEM as c on 
p.COD_PRODUCTO = c.COD_PRODUCTO
GO
/****** Object:  View [dbo].[V_COMBOITEM]    Script Date: 08/21/2021 12:43:48 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
create view [dbo].[V_COMBOITEM]
as
select *
from T_COMBO_ITEM
GO
/****** Object:  View [dbo].[V_CALL_CENTER]    Script Date: 08/21/2021 12:43:48 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
create view [dbo].[V_CALL_CENTER]
as
select c.NUM_CONTRATO, c.OFICINA as OFICINA ,MAX(c.COD_VENDEDOR)as VENDEDOR,
MAX(c.FEC_GENERADO)as FECHA_GENERADO,SUM(ci.PRECIO) as MONTO from T_CALL_CENTER as c
inner join T_CALL_CENTER_ITEM as ci on
c.NUM_CONTRATO = ci.NUM_CONTRATO
and c.OFICINA = ci.OFICINA
Group by c.NUM_CONTRATO ,c.OFICINA
GO
/****** Object:  View [dbo].[V_BUSCAR_PRODUCTO_WEB]    Script Date: 08/21/2021 12:43:48 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE view [dbo].[V_BUSCAR_PRODUCTO_WEB]
as
	select COD_PRODUCTO as CODIGO ,COD_CATEGORIA as CATEGORIA,
	DES_PRODUCTO as DESCRIPCION, UNI_MEDIDA as UNIDAD, STOCK_MINIMO as STOCK,
	ABR_PRODUCTO as ABREVIATURA,
	PRE_PRODUCTO as PREPRODUCTO , PRECIO_WEB as PRECIO_WEB,
	PRECIO_NORTE as NORTE ,PRECIO_SUR as SUR, PESO_NETO as PESO
	from T_PRODUCTO where COD_CATEGORIA = '00004' and EST_PRODUCTO = '1'
GO
/****** Object:  View [dbo].[V_BUSCAR_PRODUCTO]    Script Date: 08/21/2021 12:43:48 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE View [dbo].[V_BUSCAR_PRODUCTO]
 as
	select p.COD_PRODUCTO as CODIGO ,MAX(c.COD_CATEGORIA) as CATEGORIA,MAX(UNI_MEDIDA) as UNI_MEDIDA, MAX(c.ABR_PRODUCTO) as ABREVIATURA,
	MAX(c.DES_PRODUCTO) as DES_PRODUCTO , p.ZONA as ZONA ,
	MAX(p.CANTIDAD) as cantidad, MAX(p.BONO) as BONO, MAX(p.PRECIO) as PRECIO,MAX(c.EST_PRODUCTO) as ESTADO ,
	MAX(c.PESO_NETO) as GRAMOS
	from T_PRODUCTO_PRECIO as p
	inner join T_PRODUCTO as c
	on p.COD_PRODUCTO = c.COD_PRODUCTO where c.COD_CATEGORIA = '00004' and c.EST_PRODUCTO = '1'
	group by p.COD_PRODUCTO , ZONA
GO
/****** Object:  View [dbo].[V_BUSCAR_COMBO]    Script Date: 08/21/2021 12:43:48 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
create view [dbo].[V_BUSCAR_COMBO]
as
	select c.COD_COMBO as COD_COMBO ,c.PRECIO as PRECIO ,p.ABR_PRODUCTO as ABR_PRODUCTO,
	p.DES_PRODUCTO as DESCRIPCION
	,c.COD_COMBO +' - '+p.DES_PRODUCTO [NOM_COMPLETO]
	from T_COMBO  as c
	inner join T_PRODUCTO as p
	on c.COD_COMBO = p.COD_PRODUCTO
GO
/****** Object:  View [dbo].[borrar2]    Script Date: 08/21/2021 12:43:48 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE view [dbo].[borrar2]
as
select * from V_CALL_CENTER where VENDEDOR = '0172'
and FECHA_GENERADO >= '27-06-2021' and FECHA_GENERADO < '08-07-2021'
GO
/****** Object:  Default [DF_T_ASISTENCIAS_FECHA]    Script Date: 08/21/2021 12:43:47 ******/
ALTER TABLE [dbo].[T_ASISTENCIAS] ADD  CONSTRAINT [DF_T_ASISTENCIAS_FECHA]  DEFAULT (getdate()) FOR [FECHA]
GO
/****** Object:  Default [DF_T_LATLNG_FECHA]    Script Date: 08/21/2021 12:43:47 ******/
ALTER TABLE [dbo].[T_LATLNG] ADD  CONSTRAINT [DF_T_LATLNG_FECHA]  DEFAULT (getdate()) FOR [FECHA]
GO
/****** Object:  Default [DF_T_PERSONAL_ENFALTA_FECH_REGISTRO]    Script Date: 08/21/2021 12:43:47 ******/
ALTER TABLE [dbo].[T_PERSONAL_ENFALTA] ADD  CONSTRAINT [DF_T_PERSONAL_ENFALTA_FECH_REGISTRO]  DEFAULT (getdate()) FOR [FECH_REGISTRO]
GO
