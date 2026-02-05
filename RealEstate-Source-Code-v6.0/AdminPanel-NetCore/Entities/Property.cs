using System;
using System.Collections.Generic;
using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;

namespace RealEstate.Entities
{
    public partial class Property
    {
        [Key]
        public int Id { get; set; }
        public int PropertyTypeId { get; set; }
        public int PropertyCategoryId { get; set; }
        public int UserId { get; set; }
        public int CityId { get; set; }
        public bool Featured { get; set; }
        public bool Visible { get; set; }
        [Required]
        [StringLength(250)]
        public string Title { get; set; }
        [Required]
        public string Description { get; set; }
        [Required]
        public string ImageNames { get; set; }
        public int Size { get; set; }
        public int BedRoomCount { get; set; }
        public int BathRoomCount { get; set; }
        public int KitchenRoomCount { get; set; }
        public int ParkingCount { get; set; }
        [Required]
        public string AdditionalFeatures { get; set; }
        [Column(TypeName = "numeric(18, 2)")]
        public decimal Price { get; set; }
        [Required]
        [StringLength(10)]
        public string Currency { get; set; }
        [Required]
        public string Address { get; set; }
        [Column(TypeName = "decimal(9, 6)")]
        public decimal Latitude { get; set; }
        [Column(TypeName = "decimal(9, 6)")]
        public decimal Longitude { get; set; }
        [Column(TypeName = "datetime")]
        public DateTime CreatedDate { get; set; }

        [ForeignKey(nameof(CityId))]
        [InverseProperty("Property")]
        public virtual City City { get; set; }
        [ForeignKey(nameof(PropertyCategoryId))]
        [InverseProperty("Property")]
        public virtual PropertyCategory PropertyCategory { get; set; }
        [ForeignKey(nameof(PropertyTypeId))]
        [InverseProperty("Property")]
        public virtual PropertyType PropertyType { get; set; }
        [ForeignKey(nameof(UserId))]
        [InverseProperty("Property")]
        public virtual User User { get; set; }
    }
}
