using libzkfpcsharp;
using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Drawing;
using System.Data;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;
using System.Threading;
using System.Runtime.InteropServices;
using System.Data.SqlClient;
using LectorHuella.Complementos;

namespace LectorHuella
{
    public partial class huellero : UserControl
    {
        Metodos m;
        private Form1 frm;
        public huellero()
        {
            FormHandle = this.Handle;
            InitializeComponent();
            IniciarDispositivo();
          
        }


        IntPtr mDBHandle = IntPtr.Zero;
        zkfp fpInstance = new zkfp();
        bool bIsTimeToDie = false;
        IntPtr mDevHandle = IntPtr.Zero;
        public int cbCapTmp = 2048;
        public byte[] FPBuffer;
        public byte[] CapTmp = new byte[2048];
        public IntPtr FormHandle = IntPtr.Zero;
        public Thread captureThread;
        String strShow;
        String valor;
        byte[][] RegTmps = new byte[3][];
        int iniciarllamado;  
        public const int MESSAGE_CAPTURED_OK = 0x0400 + 6;


        public int mfpWidth = 0;
        public int mfpHeight = 0;
      


        public void IniciarDispositivo()
        {
            int init = 0;

            iniciarllamado = fpInstance.Initialize();
            if (iniciarllamado == 0)
            {
                mDBHandle = zkfp2.DBInit();
                if (zkfp.ZKFP_ERR_OK == iniciarllamado)
                {
                    int ncantidad = fpInstance.GetDeviceCount();
                    if (ncantidad > 0)
                    {
                        init = 0;
                    }
                    else
                    {
                        int finalizar = fpInstance.Finalize();
                    }

                    int openDeviceCallBackCode = fpInstance.OpenDevice(init); //obtiene el selec del dispositivo
                    if (zkfp.ZKFP_ERR_OK != openDeviceCallBackCode)
                    {
                        Valor = "sinpuerto";
                        return;
                    }

                    for (int i = 0; i < 3; i++)
                    {

                        RegTmps[i] = new byte[2048];
                    }

                    byte[] paramValue = new byte[4];
                    int size = 4;

                    fpInstance.GetParameters(1, paramValue, ref size);
                    zkfp2.ByteArray2Int(paramValue, ref mfpWidth);

                    size = 4;
                    fpInstance.GetParameters(2, paramValue, ref size);
                    zkfp2.ByteArray2Int(paramValue, ref mfpHeight);



                    FPBuffer = new byte[mfpWidth * mfpHeight];

                    captureThread = new Thread(new ThreadStart(DoCapture));
                    captureThread.IsBackground = true;
                    captureThread.Start();
                    bIsTimeToDie = false;

                    string devSN = fpInstance.devSn;
                    Valor = "conectado";

                }
                else
                {
                    Valor = "noencontrado";
                }
            }

        }



        private void DoCapture()
        {
            while (!bIsTimeToDie)
            {
                cbCapTmp = 2048;
                int ret = fpInstance.AcquireFingerprint(FPBuffer, CapTmp, ref cbCapTmp);
                if (ret == zkfp.ZKFP_ERR_OK)
                {
                   
                    SendMessage(FormHandle, MESSAGE_CAPTURED_OK, IntPtr.Zero, IntPtr.Zero);
                }

                Thread.Sleep(200);
            }
        }

        [DllImport("user32.dll", EntryPoint = "SendMessageA")]
        public static extern int SendMessage(IntPtr hwnd, int wMsg, IntPtr wParam, IntPtr lParam);
        


          protected override void DefWndProc(ref Message m)
          {
           

            switch (m.Msg)
              {
                  case MESSAGE_CAPTURED_OK:
                      {
                          strShow = zkfp2.BlobToBase64(CapTmp, cbCapTmp); //obtiene el template de la huella dactilar lo combierte a base64
                          DisplayFingerPrintImage(strShow);
                         // LlevarDatos(strShow);
                      }
                      break;
                  default:
                      base.DefWndProc(ref m);
                      break;
              }
          }


        private void DisplayFingerPrintImage(String huella)
        {
            Metodos m = new Metodos();
            this.pictureBox1.Image = m.DisplayFingerPrintImage(FPBuffer, mfpWidth, mfpHeight, huella);
            //frm = new Form1();
            //Form frm = Form.ActiveForm;
            ;
            string formname = this.Parent.Name;
            if (formname == "panel1")
            {
                buscarHuella(huella);
            }
           
        }

        private void FingerPrintControl_Load(object sender, EventArgs e)
        {
           
        }

        private void huellero_ControlRemoved(object sender, ControlEventArgs e)
        {
          
        }

        private void buscarHuella(String huella)
        {
          
            m = new Metodos();
            Boolean verifico = false;
            SqlDataReader registros = m.verificarHuella();
           
            while (registros.Read())
            {

                

                String huella2 = registros["HUELLA"].ToString();

                byte[] blob1 = Convert.FromBase64String(huella2.Trim());
                byte[] blob2 = Convert.FromBase64String(huella.Trim());

                int ret = zkfp2.DBMatch(mDBHandle, blob1, blob2);
                if (ret >= 50)
                {
                    
                    SqlDataReader asistencia=  m.verifircarAsistencia(registros["COD_PERSONAL"].ToString());

                    //if (!asistencia.HasRows)
                   // {
                        SqlDataReader turno = m.Turnos(registros["COD_PERSONAL"].ToString());
                       

                        if (!asistencia.HasRows)
                        {
                            if (!turno.HasRows)
                            {
                                MessageBox.Show("NO TIENE TURNOS", "MENSAJE", MessageBoxButtons.OK,MessageBoxIcon.Error);
                                mensajes("error", "NO TIENE TURNOS");
                                return;
                            }
                            m.RegistrarAsistencia(registros["COD_PERSONAL"].ToString());
                            m.UpdateEstadoTurno(registros["COD_PERSONAL"].ToString());
                            MessageBox.Show("SE REGISTRO ASISTENCIA", "MENSAJE", MessageBoxButtons.OK,MessageBoxIcon.Exclamation);
                            mensajes("echo", "SE REGISTRO ASISTENCIA");
                            return;
                        }
                           
                        
                        
                    //}


                    while (asistencia.Read())
                    {
                        if (asistencia["HORA_SALIDA"].ToString() == "")
                        {
                            String hor = asistencia["HORA_SALIDA"].ToString();
                            double horas = m.comparahoras(asistencia["HORA_INGRESO"].ToString());
                            double hora2 = 1.0;
                            if (horas > hora2)
                            {
                                if (hor == "")
                                {
                                    m.RegistrarSalida(registros["COD_PERSONAL"].ToString());
                                    MessageBox.Show("SE REGISTRO SU SALIDA", "MENSAJE", MessageBoxButtons.OK,MessageBoxIcon.Exclamation);
                                    mensajes("echo", "SE REGISTRO SU SALIDA");
                                    return;
                                }
                            }
                            else
                            {
                                MessageBox.Show("YA REGISTRO SU ASISTENCIA", "MENSAJE", MessageBoxButtons.OK,
                                   MessageBoxIcon.Error);
                                mensajes("error", "YA REGISTRO SU ASISTENCIA");
                                return;
                            }
                        }
                        else
                        {
                            if (!turno.HasRows)
                            {
                                MessageBox.Show("NO TIENE TURNOS", "MENSAJE", MessageBoxButtons.OK,
                                MessageBoxIcon.Error);
                                mensajes("error", "NO TIENE TURNOS");
                                return;
                            }
                            m.RegistrarAsistencia(registros["COD_PERSONAL"].ToString());
                            m.UpdateEstadoTurno(registros["COD_PERSONAL"].ToString());
                            MessageBox.Show("SE REGISTRO ASISTENCIA", "MENSAJE", MessageBoxButtons.OK,
                                 MessageBoxIcon.Exclamation);
                            mensajes("echo", "SE REGISTRO ASISTENCIA");
                            return;
                        }
                           
                    }
                    
                }
            }

            if (!verifico)
            {
                MessageBox.Show("NO SE ENCONTRO AL USUARIO", "MENSAJE", MessageBoxButtons.OK,
                                MessageBoxIcon.Error);
                mensajes("error","NO SE ENCONTRO AL USUARIO");
                return;
            }
        }



        public void mensajes(String tipo,String mensaje)
        {
            if (tipo == "echo")
            {
                this.frm.statusbar.BackColor = Color.FromArgb(79, 208, 154);
                this.frm.statusbar.Text = mensaje;
                this.frm.statusbar.ForeColor = Color.White;
            }
            else if(tipo == "error")
            {
                this.frm.statusbar.BackColor = Color.FromArgb(230, 112, 134);
                this.frm.statusbar.Text = mensaje;
                this.frm.statusbar.ForeColor = Color.White;
            }
        }




        public void mensaje(Form1 form)
        {
            this.frm = form;
        }


        public string StrShow
        {
            get { return strShow; }
            set { strShow = value; }
        }

        public string Valor
        {
            get { return valor; }
            set { valor = value; }
        }

    }
}
