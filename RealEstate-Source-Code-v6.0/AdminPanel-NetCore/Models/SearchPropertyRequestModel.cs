using RealEstate.Entities;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;

namespace RealEstate.Models
{
    public class SearchPropertyRequestModel
    {
        public string SearchText { get; set; }
        public List<PropertyType> PropertyTypes { get; set; }
        public List<PropertyCategory> PropertyCategories { get; set; }
        public List<City> Cities { get; set; }
        public List<int> BedRoomCounts { get; set; }
        public List<int> BathRoomCounts { get; set; }
        public List<int> KitchenRoomCounts { get; set; }
        public List<int> ParkingCounts { get; set; }
        public int MinSize { get; set; }
        public int MaxSize { get; set; }
        public decimal MinPrice { get; set; }
        public decimal MaxPrice { get; set; }
        public string Address { get; set; }
    }
}
