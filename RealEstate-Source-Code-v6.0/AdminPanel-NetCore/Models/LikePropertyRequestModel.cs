using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;

namespace RealEstate.Models
{
    public class LikePropertyRequestModel
    {
        public int PropertyId { get; set; }
        public bool IsLiked { get; set; }
    }
}
