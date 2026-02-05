using System;
using System.Collections.Generic;
using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;

namespace RealEstate.Entities
{
    public partial class News
    {
        [Key]
        public int Id { get; set; }
        public int CategoryId { get; set; }
        [Required]
        [StringLength(250)]
        public string Title { get; set; }
        [Required]
        public string Content { get; set; }
        [Required]
        [StringLength(250)]
        public string ImageName { get; set; }
        [Column(TypeName = "datetime")]
        public DateTime CreatedDate { get; set; }

        [ForeignKey(nameof(CategoryId))]
        [InverseProperty(nameof(NewsCategory.News))]
        public virtual NewsCategory Category { get; set; }
    }
}
