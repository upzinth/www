using System;
using Microsoft.EntityFrameworkCore;
using Microsoft.EntityFrameworkCore.Metadata;
using RealEstate.Helpers;

namespace RealEstate.Entities
{
    public partial class RealEstateContext : DbContext
    {
        public RealEstateContext()
        {
        }

        public RealEstateContext(DbContextOptions<RealEstateContext> options)
            : base(options)
        {
        }

        public virtual DbSet<AppSettings> AppSettings { get; set; }
        public virtual DbSet<City> City { get; set; }
        public virtual DbSet<News> News { get; set; }
        public virtual DbSet<NewsCategory> NewsCategory { get; set; }
        public virtual DbSet<PasswordReset> PasswordReset { get; set; }
        public virtual DbSet<Property> Property { get; set; }
        public virtual DbSet<PropertyCategory> PropertyCategory { get; set; }
        public virtual DbSet<PropertyLikes> PropertyLikes { get; set; }
        public virtual DbSet<PropertyType> PropertyType { get; set; }
        public virtual DbSet<User> User { get; set; }

        protected override void OnModelCreating(ModelBuilder modelBuilder)
        {
            modelBuilder.Entity<AppSettings>(entity =>
            {
                entity.Property(e => e.Id).ValueGeneratedNever();

                entity.Property(e => e.CreatedDate).HasDefaultValueSql("(getdate())");

                entity.Property(e => e.UpdatedDate).HasDefaultValueSql("(getdate())");
            });

            modelBuilder.Entity<City>(entity =>
            {
                entity.Property(e => e.SearchCount).HasDefaultValueSql("((0))");
            });

            modelBuilder.Entity<News>(entity =>
            {
                entity.Property(e => e.CreatedDate).HasDefaultValueSql("(getdate())");

                entity.HasOne(d => d.Category)
                    .WithMany(p => p.News)
                    .HasForeignKey(d => d.CategoryId)
                    .OnDelete(DeleteBehavior.ClientSetNull)
                    .HasConstraintName("FK_News_NewsCategory");
            });

            modelBuilder.Entity<NewsCategory>(entity =>
            {
                entity.Property(e => e.CreatedDate).HasDefaultValueSql("(getdate())");
            });

            modelBuilder.Entity<PasswordReset>(entity =>
            {
                entity.HasIndex(e => e.Email)
                    .HasName("IX_PasswordReset");
            });

            modelBuilder.Entity<Property>(entity =>
            {
                entity.Property(e => e.CreatedDate).HasDefaultValueSql("(getdate())");

                entity.HasOne(d => d.City)
                    .WithMany(p => p.Property)
                    .HasForeignKey(d => d.CityId)
                    .OnDelete(DeleteBehavior.ClientSetNull)
                    .HasConstraintName("FK_Property_City");

                entity.HasOne(d => d.PropertyCategory)
                    .WithMany(p => p.Property)
                    .HasForeignKey(d => d.PropertyCategoryId)
                    .OnDelete(DeleteBehavior.ClientSetNull)
                    .HasConstraintName("FK_Property_PropertyCategory");

                entity.HasOne(d => d.PropertyType)
                    .WithMany(p => p.Property)
                    .HasForeignKey(d => d.PropertyTypeId)
                    .OnDelete(DeleteBehavior.ClientSetNull)
                    .HasConstraintName("FK_Property_PropertyType");

                entity.HasOne(d => d.User)
                    .WithMany(p => p.Property)
                    .HasForeignKey(d => d.UserId)
                    .OnDelete(DeleteBehavior.ClientSetNull)
                    .HasConstraintName("FK_Property_User");
            });

            modelBuilder.Entity<PropertyCategory>(entity =>
            {
                entity.Property(e => e.CreatedDate).HasDefaultValueSql("(getdate())");
            });

            modelBuilder.Entity<PropertyLikes>(entity =>
            {
                entity.HasIndex(e => new { e.PropertyId, e.UserId })
                    .HasName("Index_Property_User");
            });

            modelBuilder.Entity<PropertyType>(entity =>
            {
                entity.Property(e => e.Id).ValueGeneratedNever();
            });

            modelBuilder.Entity<User>(entity =>
            {
                entity.HasIndex(e => e.Email)
                    .HasName("IX_Email")
                    .IsUnique();

                entity.HasIndex(e => e.Username)
                    .HasName("IX_Username")
                    .IsUnique();

                entity.Property(e => e.CreatedDate).HasDefaultValueSql("(getdate())");
            });

            OnModelCreatingPartial(modelBuilder);

            #region Initialize Datas
            byte[] passwordHash, passwordSalt;
            AuthenticationHelper.CreatePasswordHash("123456", out passwordHash, out passwordSalt);

            modelBuilder.Entity<User>().HasData(new User
            {
                Id = 1,
                FirstName = "John",
                LastName = "Publ",
                PhoneNumber = "1234567890",
                Email = "admin@publsoft.com",
                Username = "admin",
                PasswordHash = passwordHash,
                PasswordSalt = passwordSalt,
                IsAdmin = true,
                IsAgent = false,
                CreatedDate = DateTime.Now
            }, new User
            {
                Id = 2,
                FirstName = "Istanbul",
                LastName = "Agent",
                PhoneNumber = "1234567890",
                Email = "agent@publsoft.com",
                Username = "agent",
                PasswordHash = passwordHash,
                PasswordSalt = passwordSalt,
                IsAdmin = false,
                IsAgent = true,
                CreatedDate = DateTime.Now
            });

            modelBuilder.Entity<PropertyType>().HasData(
                new PropertyType { Id = 1, Name = "Sale" },
                new PropertyType { Id = 2, Name = "Rent" });

            modelBuilder.Entity<AppSettings>().HasData(new AppSettings
            {
                Id = 1,
                Email = "publsoftware@gmail.com",
                Website = "http://pulsoft.com",
                AppVersion = "1.0.0",
                FacebookUrl = "https://www.facebook.com/",
                TwitterUrl = "https://www.twitter.com/",
                CreatedDate = DateTime.Now
            });
            #endregion
        }

        partial void OnModelCreatingPartial(ModelBuilder modelBuilder);
    }
}
