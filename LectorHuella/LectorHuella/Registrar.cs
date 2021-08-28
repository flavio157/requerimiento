using libzkfpcsharp;
using LectorHuella.Complementos;
using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Data.SqlClient;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;
using System.Threading;

namespace LectorHuella
{
    public partial class Registrar : Form
    {
        String Valoficina;
        huellero huellero;
        Metodos m;
        public Registrar()
        {
            InitializeComponent();
            cargarimagen();
            ocultar();
            oficina();
        }
        
        private void cargarimagen()
        {
            huellero = new huellero();
            panel2.Controls.Add(huellero);
            String valor = huellero.Valor;
            if (valor == "conectado")
            {
                statusbar.BackColor = Color.FromArgb(79, 208, 154);
                statusbar.Text = "DISPOSITIVO CONECTADO";
                statusbar.ForeColor = Color.White;
            }
            else if (valor == "noencontrado")
            {
                statusbar.Text = "NO SE ENCONTRO EL DISPOSITIVO";
                statusbar.ForeColor = Color.White;
                statusbar.BackColor = Color.FromArgb(230, 112, 134);
            }
            else if (valor == "sinpuerto")
            {
                statusbar.Text = "ERROR EN EL PUERTO USB";
                statusbar.ForeColor = Color.White;
                statusbar.BackColor = Color.FromArgb(230, 112, 134);
            }
        }

        private void btn_buscar_Click(object sender, EventArgs e)
        {
            BuscarUsuario();
        }



        public void BuscarUsuario()
        {
            String txtbperson = txtPersonal.Text.Trim();
            var ofi = CbmOficina.Text;
            if (ofi != "SELECCIONAR OFICINA")
            {
                m = new Metodos();
                SqlDataReader personal;
                personal = m.BuscarPersonalcodigo(txtbperson);
                if (personal.HasRows)
                {
                    while (personal.Read())
                    {
                        txtcodigo.Text = personal["COD_PERSONAL"].ToString();
                        txtnombre.Text = personal["NOM_PERSONAL1"].ToString();
                        txtdireccion.Text = personal["DIR_PERSONAL"].ToString();
                        txttelefono.Text = personal["TEL_PERSONAL"].ToString();
                        txtcelular.Text = personal["CEL_PERSONAL"].ToString();
                        mostrar();

                    }

                    statusbar.BackColor = Color.FromArgb(79, 208, 154);
                    statusbar.Text = "USUARIO ENCONTRADO";
                    statusbar.ForeColor = Color.White;

                }
                else
                {
                    statusbar.Text = "NO SE ENCONTRO EL USUARIO";
                    statusbar.ForeColor = Color.White;
                    statusbar.BackColor = Color.FromArgb(230, 112, 134);
                    ocultar();
                }
            }
        }



        public void mostrar()
        {
            lblCodigo.Visible = true;
            txtcodigo.Visible = true;
            lblnombre.Visible = true;
            txtnombre.Visible = true;
            lbldireccion.Visible = true;
            txtdireccion.Visible = true;
            lbltelefono.Visible = true;
            txttelefono.Visible = true;
            lblcelular.Visible = true;
            txtcelular.Visible = true;
            //imagen.Visible = true;
            //lblFingerPrintCount.Visible = true;
            Size = new Size(565, 575);
        }



        public void ocultar()
        {
            lblCodigo.Visible = false;
            txtcodigo.Visible = false;
            lblnombre.Visible = false;
            txtnombre.Visible = false;
            lbldireccion.Visible = false;
            txtdireccion.Visible = false;
            lbltelefono.Visible = false;
            txttelefono.Visible = false;
            lblcelular.Visible = false;
            txtcelular.Visible = false;
            // imagen.Visible = false;
            //lblFingerPrintCount.Visible = false;
            Size = new Size(568, 220);

        }

        public void oficina()
        {
            Oficina oficina = new Oficina();
            Valoficina = oficina.valOficina;
            CbmOficina.Items.Add(Valoficina);
            CbmOficina.SelectedIndex = 0;
        }

        

        private void btn_registrarHuella_Click(object sender, EventArgs e)
        {
            m = new Metodos();
           
            String huella = huellero.StrShow;
            if (huella != "")
            {
                SqlDataReader personal;
               personal  = m.VerificarRegistro(txtcodigo.Text);
                if (!personal.HasRows)
                {
                    String usuario_registro = "";
                    m.RegistrarHuella(txtcodigo.Text, huella, usuario_registro);
                    statusbar.BackColor = Color.FromArgb(79, 208, 154);
                    statusbar.Text = "SE REGISTRO AL USUARIO";
                    statusbar.ForeColor = Color.White;
                }
                else
                {
                    statusbar.Text = "USUARIO YA REGISTRADO";
                    statusbar.ForeColor = Color.White;
                    statusbar.BackColor = Color.FromArgb(230, 112, 134);
                }
              
            }
        }

        private void Registrar_FormClosing(object sender, FormClosingEventArgs e)
        {

           

        }

        private void btn_regresar_Click(object sender, EventArgs e)
        {
            zkfp fpInstance = new zkfp();

            Thread.Sleep(1000);
            int result = fpInstance.CloseDevice();
            huellero.captureThread.Abort();

            Thread.Sleep(1000);
            result = fpInstance.Finalize();
            panel2.Controls.Remove(huellero);
            this.Hide();
            Form1 frm = new Form1();
            frm.Show();
        }

        private void Registrar_FormClosed(object sender, FormClosedEventArgs e)
        {
            zkfp fpInstance = new zkfp();

            Thread.Sleep(1000);
            int result = fpInstance.CloseDevice();
            huellero.captureThread.Abort();

            Thread.Sleep(1000);
            result = fpInstance.Finalize();
            Application.Exit();
        }
    }
}
