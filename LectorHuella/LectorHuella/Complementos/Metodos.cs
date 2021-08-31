using LectorHuella.Complementos;
using Registro.conexion;
using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Drawing;
using System.IO;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;

namespace LectorHuella
{
    class Metodos
    {

        public SqlDataReader verificarHuella()
        {

            DatabaseDinamica cn = new DatabaseDinamica();
            String cadena = "SELECT * FROM T_HUELLA";
            SqlCommand comando = new SqlCommand(cadena, cn.AbrirConexion());
            SqlDataReader registros = comando.ExecuteReader();

            return registros;
        }


        public void RegistrarHuella(String cod_personal, String huella, String usu_registro)
        {
            DatabaseDinamica cn = new DatabaseDinamica();
            String cadena = "INSERT INTO T_HUELLA(COD_PERSONAL,HUELLA,USU_REGISTRO) VALUES('" + cod_personal + "','" + huella + "','" + usu_registro + "')";
            SqlCommand comando = new SqlCommand(cadena, cn.AbrirConexion());
            comando.ExecuteNonQuery();
        }


        public SqlDataReader BuscarPersonalcodigo(String dni_persona)
        {
            DatabaseDinamica cn = new DatabaseDinamica();
            String cadena = "SELECT * FROM T_PERSONAL WHERE DNI_PERSONAL ='" + dni_persona + "'";
            SqlCommand comando = new SqlCommand(cadena, cn.AbrirConexion());
            SqlDataReader Personal = comando.ExecuteReader();
            return Personal;

        }
        
        public Bitmap DisplayFingerPrintImage(byte[] FPBuffer, int mfpWidth, int mfpHeight, String huella)
        {
            MemoryStream ms = new MemoryStream();
            GenerarImagen.GetBitmap(FPBuffer, mfpWidth, mfpHeight, ref ms);
            Bitmap bmp = new Bitmap(ms);
            return bmp;
        }

        public SqlDataReader VerificarRegistro(String cod_personal)
        {
            DatabaseDinamica cn = new DatabaseDinamica();
            String cadena = "SELECT * FROM T_HUELLA WHERE COD_PERSONAL ='" +cod_personal+ "'";
            SqlCommand comando = new SqlCommand(cadena, cn.AbrirConexion());
            SqlDataReader Personal = comando.ExecuteReader();
            return Personal;
        }

        public void RegistrarAsistencia(String cod_personal)
        {
            String hora = DateTime.Now.ToString("hh:mm");
            String fecha = DateTime.Now.ToString("yyyy-dd-MM").ToString();
            DatabaseDinamica cn = new DatabaseDinamica();
            String cadena = "INSERT INTO T_ASISTENCIAS(FECHA,COD_PERSONAL,HORA_INGRESO)VALUES('"+fecha+"','"+ cod_personal + "','" + hora + "')";
            SqlCommand comando = new SqlCommand(cadena, cn.AbrirConexion());
            comando.ExecuteNonQuery();
        }

        public SqlDataReader verifircarAsistencia(String cod_personal)
        {
            String fecha = this.fecha();
            DatabaseDinamica cn = new DatabaseDinamica();
            String cadena = "SELECT TOP 1 * FROM T_ASISTENCIAS WHERE COD_PERSONAL ='" + cod_personal + "'AND FECHA='"+fecha+ "' order by CODIGO desc";
            SqlCommand comando = new SqlCommand(cadena, cn.AbrirConexion());
            SqlDataReader Personal = comando.ExecuteReader();
            return Personal;
        }

        public void RegistrarSalida(String cod_personal)
        {
            String fecha = this.fecha();
            String hora = this.hora();
            DatabaseDinamica cn = new DatabaseDinamica();
            String cadena = "UPDATE T_ASISTENCIAS SET HORA_SALIDA ='"+hora+"' WHERE COD_PERSONAL = '" +cod_personal+ "' AND FECHA ='" +fecha+ "'";
            SqlCommand comando = new SqlCommand(cadena, cn.AbrirConexion());
            comando.ExecuteNonQuery();
        }


        public String hora()
        {
            String hora = DateTime.Now.ToString("hh:mm");
            return hora;
        }

        public String fecha()
        {
            String fecha = DateTime.Now.ToString("yyyy-dd-MM").ToString();
            return fecha;
        }

        public double comparahoras(String hora1)
        {
            TimeSpan diferenciaHoras = new TimeSpan();
            DateTime fechaInicio = new DateTime();
            fechaInicio = DateTime.Parse(hora1);

            DateTime fechaLlegada = new DateTime();
            fechaLlegada = DateTime.Parse(this.hora());

            diferenciaHoras = fechaLlegada - fechaInicio;
           // int horas = diferenciaHoras.Hours;
            double horasTotales = diferenciaHoras.TotalHours;
            return horasTotales;
        }


        public SqlDataReader Turnos(String cod_personal)
        {
            DatabaseDinamica cn = new DatabaseDinamica();
            String cadena = "SELECT TOP 1 * FROM T_PERSONAL_HORARIO WHERE COD_PERSONAL='" + cod_personal + "' AND ESTADO = 'A' AND SITUACION != 1";
            SqlCommand comando = new SqlCommand(cadena, cn.AbrirConexion());
            SqlDataReader Personal = comando.ExecuteReader();
            return Personal;
        }
        
        public void UpdateEstadoTurno( String cod_personal)
        {
            DatabaseDinamica cn = new DatabaseDinamica();
            String cadena = "UPDATE TOP(1) T_PERSONAL_HORARIO set SITUACION = 1 WHERE COD_PERSONAL = '" + cod_personal+ "'AND ESTADO = 'A' AND SITUACION != 1";
            SqlCommand comando = new SqlCommand(cadena, cn.AbrirConexion());
            comando.ExecuteNonQuery();
        }
    }
}
