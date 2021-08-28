using LectorHuella.Complementos;
using libzkfpcsharp;
using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading;
using System.Threading.Tasks;
using System.Windows.Forms;

namespace LectorHuella
{
    public partial class Form1 : Form
    {
        huellero huellero;
        public int estado;
        public Form1()
        {
            InitializeComponent();
            cargarimagen();
            estado = 1;
        }

        private void button1_Click(object sender, EventArgs e)
        {
            
            zkfp fpInstance = new zkfp();
            Thread.Sleep(1000);
            int result = fpInstance.CloseDevice();
            huellero.captureThread.Abort();
            Thread.Sleep(1000);
            result = fpInstance.Finalize();
            this.Hide();
            panel1.Controls.Remove(huellero);
            Registrar frmregistrar = new Registrar();
            estado = 0;
            frmregistrar.Show();
        }
        

        private void cargarimagen()
        {
             huellero = new huellero();
             huellero.Dock = DockStyle.Fill;
             panel1.Controls.Add(huellero);
             String valor = huellero.Valor;
             huellero.mensaje(this);
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

        private void Form1_Load(object sender, EventArgs e)
        {
            tiempo.Enabled = true;
        }

        private void tiempo_Tick(object sender, EventArgs e)
        {
            lblhora.Text = DateTime.Now.ToString("hh:mm:ss");
        }

        private void Form1_FormClosed(object sender, FormClosedEventArgs e)
        {
            try
            {
                zkfp fpInstance = new zkfp();
                panel1.Controls.Remove(huellero);
                Thread.Sleep(1000);
                int result = fpInstance.CloseDevice();
                huellero.captureThread.Abort();
                Thread.Sleep(1000);
                result = fpInstance.Finalize();
                Application.Exit();
                //this.Close();
            }
            catch  {
                //MessageBox.Show("Error dispotivo no conectado"+ e);
            }

        }
    }
}
