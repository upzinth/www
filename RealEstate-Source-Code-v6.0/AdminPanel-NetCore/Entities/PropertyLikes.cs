using System;
using System.Collections.Generic;
using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;

namespace RealEstate.Entities
{
    public partial class PropertyLikes
    {
        [Key]
        public int Id { get; set; }
        public int PropertyId { get; set; }
        public int UserId { get; set; }
    }
}
