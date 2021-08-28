using System;
using System.Collections;
using System.Collections.Generic;
using System.IO;
using System.Linq;
using System.Net;
using System.Net.Mail;
using System.Net.Security;
using System.Runtime.InteropServices;
using System.Security.Cryptography.X509Certificates;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;

namespace csomss
{
    [ComVisible(true)]
    [ProgId("csomss.correo")]
    [ClassInterface(ClassInterfaceType.None)]
    public class correo
    {
        string From = ""; //de quien procede, puede ser un alias
        string To;  //a quien vamos a enviar el mail
        string Message;  //mensaje
        string Subject; //asunto
        ArrayList Archivo = new ArrayList(); //lista de archivos a enviar
        string DE = "izuma.san.98@gmail.com"; //nuestro usuario de smtp
        string PASS = "SolisPacotaipe"; //nuestro password de smtp
        string archivo;
        MailMessage Email;
 
        public string error = "";

        [ComVisible(true)]
        public void smss(string FROM, string Para, string Mensaje, string Asunto,string txtarchivo)
        {
            From = FROM;
            To = Para;
            Message = Mensaje;
            Subject = Asunto;
        }

        [ComVisible(true)]
        public void adjuntararchivos(string txtarchivo)
        {
            Archivo.Add(txtarchivo);
        }
        

        public bool enviar()
        {
            bool valor = enviaMail();
            return valor;
        }

        private bool enviaMail()
        {
            if (To.Trim().Equals("") || Message.Trim().Equals("") || Subject.Trim().Equals(""))
            {
                error = "El mail, el asunto y el mensaje son obligatorios";
                return false;
            }
  

            try
            {
                Email = new MailMessage();
                  if (Archivo != null)
                  {
                      //agregado de archivo
                      foreach (string archivo in Archivo)
                      {
                          //comprobamos si existe el archivo y lo agregamos a los adjuntos
                          if (System.IO.File.Exists(@archivo))
                              Email.Attachments.Add(new Attachment(@archivo));
                      }
                  }

                Email.IsBodyHtml = true; //definimos si el contenido sera html
                Email.From = new MailAddress(From, "LABSABELL", System.Text.Encoding.UTF8); //definimos la direccion de procedencia
                Email.To.Add(To); //Correo destino
                Email.Subject = Subject; //Asunto
                Email.Body = Message; //Mensaje del correo

                System.Net.Mail.SmtpClient smtpMail = new System.Net.Mail.SmtpClient("smtp.gmail.com");

                Email.Priority = MailPriority.Normal;
                smtpMail.UseDefaultCredentials = false; //le decimos que no utilice la credencial por defecto
                smtpMail.Host = "smtp.gmail.com"; //agregamos el servidor smtp
                smtpMail.Port = 25; //le asignamos el puerto, en este caso gmail utiliza el 465
                smtpMail.Credentials = new System.Net.NetworkCredential(DE, PASS); //agregamos nuestro usuario y pass de gmail
                ServicePointManager.ServerCertificateValidationCallback = delegate (object s, X509Certificate certificate, X509Chain chain, SslPolicyErrors sslPolicyErrors) { return true; };
                smtpMail.EnableSsl = true;//True si el servidor de correo permite ssl
                smtpMail.Send(Email);
                smtpMail.Dispose();
                return true;
            }
            catch (Exception ex)
            {
                error = "Ocurrio un error: " + ex.Message;
                return false;
            }
        }



        [ComVisible(true)]
        public String openfile()
        {
            var fileContent = string.Empty;
            var filePath = string.Empty;
            
            using (OpenFileDialog openFileDialog = new OpenFileDialog())
            {
                openFileDialog.Multiselect = true;
                openFileDialog.InitialDirectory = "c:\\";
                openFileDialog.Filter = "txt files (*.txt)|*.txt|All files (*.*)|*.*";
                openFileDialog.FilterIndex = 2;
                openFileDialog.RestoreDirectory = true;

                if (openFileDialog.ShowDialog() == DialogResult.OK)
                {
                    /*foreach (String file in openFileDialog.FileNames)
                    {
                        FileInfo fi = new FileInfo(file);
                        var nombre = fi.Name;
                        MessageBox.Show("File Content at path: " + nombre);
                    }*/
                    filePath = openFileDialog.FileName;
                }
            }

            archivo = filePath;
            return filePath;
        }


    }
}
