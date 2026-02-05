using System;
using System.Collections.Generic;
using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;

namespace RealEstate.Entities
{
    public partial class City
    {
        public City()
        {
            Property = new HashSet<Property>();
        }

        [Key]
        public int Id { get; set; }
        [Required]
        [StringLength(250)]
        public string Name { get; set; }
        [StringLength(250)]
        public string ImageName { get; set; }
        public int? SearchCount { get; set; }

        [InverseProperty("City")]
        public virtual ICollection<Property> Property { get; set; }
    }
}
