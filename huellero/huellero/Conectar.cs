using libzkfpcsharp;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Runtime.InteropServices;
using System.Text;
using System.Threading;
using System.Drawing;
using System.Threading.Tasks;
using System.IO;
using System.Drawing.Imaging;

namespace huellero
{
    [ComVisible(true)]
    [ProgId("huellero.Conectar")]
    [ClassInterface(ClassInterfaceType.None)]
    public class Conectar
    {
       
        IntPtr mDBHandle = IntPtr.Zero;
        zkfp fpInstance = new zkfp();
        String strShow;
        IntPtr mDevHandle = IntPtr.Zero;
        public int cbCapTmp = 2048;
        public byte[] FPBuffer;
        public byte[] CapTmp = new byte[2048];
        public IntPtr FormHandle = IntPtr.Zero;
        public Thread captureThread;
        bool bIsTimeToDie = false;
       
        String valor;
        byte[][] RegTmps = new byte[3][];
        int iniciarllamado;

        public const String MESSAGE_CAPTURED_OK ="hecho";


        public int mfpWidth = 0;
        public int mfpHeight = 0;


        public String IniciarDispositivo()
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
                        valor = "Dispositivo conectado pero sin acceso";
                        return valor;
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
                    valor = "Lector conectado e iniciado";
                }
                else
                {
                    valor = "No se pudo Iniciar el Lector";
                }
            }
            else
            {
                valor = "No se encontro el dispositivo";
            }

            return valor;
        }


        private void DoCapture()
        {
            while (!bIsTimeToDie)
            {
                cbCapTmp = 2048;
                int ret = fpInstance.AcquireFingerprint(FPBuffer, CapTmp, ref cbCapTmp);
                if (ret == zkfp.ZKFP_ERR_OK)
                {
                    mostrarhuella();
                }
                
                Thread.Sleep(200);
            }
        }

        [ComVisible(true)]
        public void limpiarhuella()
        {
            Huella = "";
            
        }



        [ComVisible(true)]
        public void mostrarhuella()
        {
            if (MESSAGE_CAPTURED_OK == "hecho")
            {
                strShow = zkfp2.BlobToBase64(CapTmp, cbCapTmp);
                Huella = strShow;
                DisplayFingerPrintImage(strShow);
            }

        }

        
        private String huella;

        [ComVisible(true)]
        public String Huella
        {
            get
            {
                return huella;
            }

            set
            {
                huella = value;
            }
        }


        private void DisplayFingerPrintImage(String huella)
        {
             DisplayFingerPrintImage(FPBuffer, mfpWidth, mfpHeight, huella);
        }

        [ComVisible(true)]
        public String CerrarConexion()
        {
            String Mensaje;
            try{
                Thread.Sleep(1000);
                int result = fpInstance.CloseDevice();
                captureThread.Abort();
                Thread.Sleep(1000);
                result = fpInstance.Finalize();
                Mensaje = "Se Cerro Conexion";
            }
            catch (Exception e)
            {
                Mensaje = "Error" + e;    
            }
            return Mensaje;
        }



        private void DisplayFingerPrintImage(byte[] FPBuffer, int mfpWidth, int mfpHeight, String huella)
        {
            MemoryStream ms = new MemoryStream();
            GenerarImagen.GetBitmap(FPBuffer, mfpWidth, mfpHeight, ref ms);
            Bitmap bmp = new Bitmap(ms);
            guardarimg(bmp);
        }

        public void guardarimg(Bitmap myBitmap)
        {
            string path = "C:\\Users\\User\\Documents\\WindowsPowerShell\\Shapes025.jpg";
            bool result = File.Exists(path);
            if (result == true)
            {
                File.Delete(path);
            }
            ImageCodecInfo myImageCodecInfo;
            System.Drawing.Imaging.Encoder myEncoder;
            EncoderParameter myEncoderParameter;
            EncoderParameters myEncoderParameters;

            myImageCodecInfo = GetEncoderInfo("image/jpeg");
            // para el parametro de calidad
            myEncoder = System.Drawing.Imaging.Encoder.Quality;
            myEncoderParameters = new EncoderParameters(1);
            //guardar el bitmap en una imagen jpeg con calidad 25 
            //si se quiere cambiar calidad de imagen poner 50L o 75L
            myEncoderParameter = new EncoderParameter(myEncoder, 25L);
            myEncoderParameters.Param[0] = myEncoderParameter;
            myBitmap.Save("Shapes025.jpg", myImageCodecInfo, myEncoderParameters);
            
        }

        private static ImageCodecInfo GetEncoderInfo(String mimeType)
        {
            int j;
            ImageCodecInfo[] encoders;
            encoders = ImageCodecInfo.GetImageEncoders();
            for (j = 0; j < encoders.Length; ++j)
            {
                if (encoders[j].MimeType == mimeType)
                    return encoders[j];
            }
            return null;
        }


        public int compararhuellas(String huella2)
        {
            byte[] blob1 = Convert.FromBase64String(huella2.Trim());
            byte[] blob2 = Convert.FromBase64String(Huella.Trim());

            int ret = zkfp2.DBMatch(mDBHandle, blob1, blob2);

            return ret;
        }
        
    }
}

