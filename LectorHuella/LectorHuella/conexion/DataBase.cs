using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Data.SqlClient;

namespace Registro.conexion
{
    class DataBase
    {
        private SqlConnection Con = new SqlConnection("Server=192.168.1.23;DataBase=ALMACENES;user id = sa; password = 123");
        public SqlConnection AbrirConexion()
        {
            if (Con.State == System.Data.ConnectionState.Closed)
                Con.Open();
            return Con;
        }





        /*  public SqlConnection CerrarConexion()
          {
              if (Con.State == System.Data.ConnectionState.Open)
                  Con.Close();
              return Con;
          }*/


    }
}

/*create table T_HUELLA(
	ID  int identity,
	COD_PERSONAL char(5),	
	HUELLA varbinary(MAX),
	FEC_REGISTRO datetime,
	USU_REGISTRO char(6),
	FEC_MODIFICO datetime,
	USU_MODIFICO char(6)
)*/

