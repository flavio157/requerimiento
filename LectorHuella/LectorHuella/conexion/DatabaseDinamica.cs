using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Data.SqlClient;
using LectorHuella.Complementos;

namespace Registro.conexion
{
    class DatabaseDinamica
    {
      private static String Oficina;
        private static String usuario;
        private static String password;
        private SqlConnection Con;
        Oficina o = new Oficina();
        public DatabaseDinamica()
        {
            Oficina = o.valOficina;
            usuario = o.valUsuario;
            password = o.valPassword;
        }
        

         
        public SqlConnection AbrirConexion()
        {
            Con = new SqlConnection("Server=DESKTOP-PCSH8QU;DataBase='" + Oficina + "';user id ='"+usuario+ "'; password = '"+password+"'");
            if (Con.State == System.Data.ConnectionState.Closed)
                Con.Open();
            return Con;
        }

    }
}
