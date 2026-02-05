using RealEstate.Entities;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;

namespace RealEstate.Models
{
    public class HomeLikedPropertiesModel
    {
        public Property Property { get; set; }
        public int Count { get; set; }
    }
}
