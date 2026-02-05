using System;
using System.Collections.Generic;
using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;

namespace RealEstate.Entities
{
    public partial class PropertyCategory
    {
        public PropertyCategory()
        {
            Property = new HashSet<Property>();
        }

        [Key]
        public int Id { get; set; }
        [Required]
        [StringLength(250)]
        public string Name { get; set; }
        [Column(TypeName = "datetime")]
        public DateTime CreatedDate { get; set; }

        [InverseProperty("PropertyCategory")]
        public virtual ICollection<Property> Property { get; set; }
    }
}
