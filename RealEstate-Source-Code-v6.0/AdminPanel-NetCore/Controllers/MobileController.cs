using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;
using Microsoft.AspNetCore.Http;
using Microsoft.AspNetCore.Mvc;
using RealEstate.Entities;
using Microsoft.EntityFrameworkCore;
using Microsoft.AspNetCore.Authorization;
using RealEstate.Models;
using RealEstate.Helpers;
using System.IO;

namespace RealEstate.Controllers
{
    [Authorize]
    [Route("api/v1")]
    [ApiController]
    public class MobileController : BaseController
    {
        private readonly RealEstateContext _context;

        public MobileController(RealEstateContext context)
        {
            _context = context;
        }

        #region Dashboard
        [AllowAnonymous]
        [HttpGet("dashboard")]
        public IActionResult Dashboard()
        {
            var appSettings = _context.AppSettings.AsNoTracking().FirstOrDefault();
            var headerImages = appSettings != null && appSettings.HeaderImages != null ? appSettings.HeaderImages.Split(",").ToList() : new List<string>();

            var featuredProperties = _context.Property.AsNoTracking()
                .Include(a => a.City).Include(a => a.PropertyCategory).Include(a => a.PropertyType).Include(a => a.User)
                .Where(a=> a.Visible)
                .OrderByDescending(a => a.CreatedDate).Where(a => a.Featured).Take(5).ToList();

            var newProperties = _context.Property.AsNoTracking()
                .Include(a => a.City).Include(a => a.PropertyCategory).Include(a => a.PropertyType).Include(a => a.User)
                .Where(a => a.Visible)
                .OrderByDescending(a => a.CreatedDate).Take(5)
                .ToList();

            var topSearchCities = _context.City.AsNoTracking().OrderByDescending(a => a.SearchCount).Take(10).ToList();

            return Ok(new
            {
                headerImages,
                featuredProperties,
                newProperties,
                topSearchCities
            });
        }
        #endregion

        #region Search
        [AllowAnonymous]
        [HttpPost("properties/search")]
        public IActionResult SearchProperties(SearchPropertyRequestModel model)
        {
            var newProperties = _context.Property.AsNoTracking()
               .Include(a => a.City).Include(a => a.PropertyCategory).Include(a => a.PropertyType).Include(a => a.User)
               .Where(a => a.Visible)
               .OrderByDescending(a => a.CreatedDate)
               .AsQueryable();

            if (!string.IsNullOrEmpty(model.SearchText))
                newProperties = newProperties.Where(a => a.Title.ToLower().Contains(model.SearchText.ToLower()) || a.AdditionalFeatures.ToLower().Contains(model.SearchText.ToLower()));

            if (model.PropertyTypes.Count > 0)
                newProperties = newProperties.Where(a => model.PropertyTypes.Contains(a.PropertyType));

            if (model.PropertyCategories.Count > 0)
                newProperties = newProperties.Where(a => model.PropertyCategories.Contains(a.PropertyCategory));

            if (model.Cities.Count > 0)
                newProperties = newProperties.Where(a => model.Cities.Contains(a.City));

            var bedRoomCount = model.BedRoomCounts.Count > 0 ? model.BedRoomCounts[0] : 0;
            if (bedRoomCount > 0)
                newProperties = bedRoomCount == 5 ? newProperties.Where(a => a.BedRoomCount >= bedRoomCount)
                    : newProperties.Where(a => a.BedRoomCount == bedRoomCount);

            var bathRoomCount = model.BathRoomCounts.Count > 0 ? model.BathRoomCounts[0] : 0;
            if (bathRoomCount > 0)
                newProperties = bathRoomCount == 5 ? newProperties.Where(a => a.BathRoomCount >= bathRoomCount)
                    : newProperties.Where(a => a.BathRoomCount == bathRoomCount);

            var kitchenRoomCount = model.KitchenRoomCounts.Count > 0 ? model.KitchenRoomCounts[0] : 0;
            if (kitchenRoomCount > 0)
                newProperties = kitchenRoomCount == 5 ? newProperties.Where(a => a.KitchenRoomCount >= kitchenRoomCount)
                    : newProperties.Where(a => a.KitchenRoomCount == kitchenRoomCount);

            var parkingCount = model.ParkingCounts.Count > 0 ? model.ParkingCounts[0] : 0;
            if (parkingCount > 0)
                newProperties = parkingCount == 5 ? newProperties.Where(a => a.ParkingCount >= parkingCount)
                    : newProperties.Where(a => a.ParkingCount == parkingCount);

            newProperties = newProperties.Where(a => a.Price >= model.MinPrice && a.Price <= model.MaxPrice);
            newProperties = newProperties.Where(a => a.Size >= model.MinSize && a.Size <= model.MaxSize);

            if (!string.IsNullOrEmpty(model.Address))
                newProperties = newProperties.Where(a => a.Address.Contains(model.Address));

            var resultList = newProperties.ToList();
            return Ok(resultList);
        }

        [AllowAnonymous]
        [HttpGet("properties/search/constants")]
        public IActionResult SearchConstants()
        {
            var result = new
            {
                propertyTypes = _context.PropertyType.ToList(),
                propertyCategories = _context.PropertyCategory.ToList(),
                cities = _context.City.ToList()
            };
            return Ok(result);
        }
        #endregion

        #region Property
        [HttpGet("properties/likes")]
        public IActionResult LikedProperties()
        {
            var likedProperties = from pl in _context.PropertyLikes
                                  join p in _context.Property.Include(a => a.City).Include(a => a.PropertyCategory).Include(a => a.PropertyType).Include(a => a.User)
                                  on pl.PropertyId equals p.Id
                                  where pl.UserId == UserId
                                  select p;
            return Ok(likedProperties);
        }

        [HttpPost("properties/like")]
        public async Task<IActionResult> LikeProperty(LikePropertyRequestModel model)
        {
            if (model.IsLiked)
            {
                if (!_context.PropertyLikes.Any(a => a.PropertyId == model.PropertyId && a.UserId == UserId))
                {
                    _context.PropertyLikes.Add(new PropertyLikes
                    {
                        PropertyId = model.PropertyId,
                        UserId = UserId
                    });
                    await _context.SaveChangesAsync();
                }
            }
            else
            {
                var entity = _context.PropertyLikes.FirstOrDefault(a => a.PropertyId == model.PropertyId && a.UserId == UserId);
                if (entity != null)
                {
                    _context.PropertyLikes.Remove(entity);
                    await _context.SaveChangesAsync();
                }
            }
            return Ok();
        }
        #endregion

        #region Settings
        [AllowAnonymous]
        [HttpGet("appsettings")]
        public IActionResult AppSettings()
        {
            return Ok(_context.AppSettings.FirstOrDefault(a => a.Id == SettingsController.DEFAULT_RECORD_ID));
        }

        [AllowAnonymous]
        [HttpGet("appsettings/aboutus")]
        public IActionResult AboutUs()
        {
            var appSettings = _context.AppSettings.FirstOrDefault(a => a.Id == SettingsController.DEFAULT_RECORD_ID);
            if (appSettings == null) return Ok(new { AboutUs = "", WebSite = "" });
            return Ok(new
            {
                appSettings.AboutUs,
                appSettings.Website
            });
        }

        [AllowAnonymous]
        [HttpGet("appsettings/userterms")]
        public IActionResult UserTerms()
        {
            var appSettings = _context.AppSettings.FirstOrDefault(a => a.Id == SettingsController.DEFAULT_RECORD_ID);
            if (appSettings == null) return Ok(new { UserTerms = "" });
            return Ok(new
            {
                appSettings.UserTerms,
            });
        }

        [AllowAnonymous]
        [HttpGet("appsettings/privacypolicy")]
        public IActionResult PrivacyPolicy()
        {
            var appSettings = _context.AppSettings.FirstOrDefault(a => a.Id == SettingsController.DEFAULT_RECORD_ID);
            if (appSettings == null) return Ok(new { PrivacyPolicy = "" });
            return Ok(new
            {
                appSettings.PrivacyPolicy,
            });
        }

        #endregion

        #region News
        [AllowAnonymous]
        [HttpGet("news")]
        public IActionResult News()
        {
            return Ok(_context.News.Include(a => a.Category));
        }

        #endregion

        #region User
        [HttpGet("profile/userinfo")]
        public IActionResult UserInfo()
        {
            var user = _context.User.FirstOrDefault(a => a.Id == UserId);
            return Ok(new { user });
        }

        [HttpPost("profile/updateprofileimage")]
        public async Task<IActionResult> UpdateProfileImage(IFormFile image)
        {
            var user = _context.User.FirstOrDefault(a => a.Id == UserId);
            if (user.ImageName != null)
                FileHelper.removeImageFile(user.ImageName);

            var fileName = Guid.NewGuid().ToString() + Path.GetExtension(image.FileName);
            var filePath = Path.Combine(Directory.GetCurrentDirectory(), @"UploadFiles\Images", fileName);

            using (var stream = System.IO.File.Create(filePath))
                await image.CopyToAsync(stream);

            user.ImageName = fileName;
            await _context.SaveChangesAsync();

            return Ok(fileName);
        }
        #endregion
    }
}