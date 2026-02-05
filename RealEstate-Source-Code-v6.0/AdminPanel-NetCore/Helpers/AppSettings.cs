using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;

namespace RealEstate.Helpers
{
    public class AppSettings
    {
        public string Secret { get; set; }
        public string MailHost { get; set; }
        public int MailPort { get; set; }
        public string MailAddress { get; set; }
        public string MailPassword { get; set; }
    }
}
