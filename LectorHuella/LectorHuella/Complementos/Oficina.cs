using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;

namespace LectorHuella.Complementos
{
    class Oficina
    {
        public String valOficina;
        public String valUsuario;
        public String valPassword;

        public Oficina()
        {
            String ruta = Environment.SystemDirectory + "\\Sistemas.ini";
            var MyIni = new Configuracion(ruta);
            valOficina = MyIni.Read("BaseDatos", "Sistema");
            valUsuario = MyIni.Read("IdLogin", "Sistema");
            valPassword = MyIni.Read("IdPwd", "Sistema");
        }

    }
}
