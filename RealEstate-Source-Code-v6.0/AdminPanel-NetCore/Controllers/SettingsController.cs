using System;
using System.Linq;
using System.Threading.Tasks;
using Microsoft.AspNetCore.Authentication.Cookies;
using Microsoft.AspNetCore.Authorization;
using Microsoft.AspNetCore.Mvc;
using RealEstate.Entities;
using RealEstate.Helpers;
using RealEstate.ViewModels;

namespace RealEstate.Controllers
{
    [Authorize(Roles = "Admin,Agent", AuthenticationSchemes = CookieAuthenticationDefaults.AuthenticationScheme)]
    public class SettingsController : BaseController
    {
        public static readonly int DEFAULT_RECORD_ID = 1;
        private readonly RealEstateContext _context;

        public SettingsController(RealEstateContext context)
        {
            _context = context;
        }

        // GET: Settings
        public async Task<IActionResult> Index()
        {
            var appSettings = _context.AppSettings.SingleOrDefault(a => a.Id == DEFAULT_RECORD_ID);
            if (appSettings == null)
            {
                appSettings = new Entities.AppSettings
                {
                    Id = 1,
                    UpdatedDate = DateTime.Now,
                    CreatedDate = DateTime.Now
                };
                _context.AppSettings.Add(appSettings);
                await _context.SaveChangesAsync();
            }

            var user = _context.User.FirstOrDefault(a => a.Id == UserId);

            return View(new SettingsViewModel
            {
                AppSettings = appSettings,
                FirstName = user.FirstName,
                LastName = user.LastName,
                PhoneNumber = user.PhoneNumber,
                Email = user.Email,
                Address = user.Address,
                Latitude = user.Latitude,
                Longitude = user.Longitude,
                Username = user.Username
            });
        }

        [HttpPost]
        [ValidateAntiForgeryToken]
        public async Task<IActionResult> Index(SettingsViewModel viewModel)
        {
            if (ModelState.IsValid)
            {
                var appSettings = viewModel.AppSettings;
                if (appSettings != null)
                {
                    appSettings.Id = DEFAULT_RECORD_ID;
                    appSettings.UpdatedDate = DateTime.Now;
                    _context.Update(viewModel.AppSettings);
                }

                var user = _context.User.FirstOrDefault(a => a.Id == UserId);
                user.FirstName = viewModel.FirstName;
                user.LastName = viewModel.LastName;
                user.PhoneNumber = viewModel.PhoneNumber;
                user.Address = viewModel.Address;
                user.Latitude = viewModel.Latitude;
                user.Longitude = viewModel.Longitude;

                if (user.Username != viewModel.Username)
                {
                    if (_context.User.Any(x => x.Username == viewModel.Username))
                    {
                        ModelState.AddModelError("Username", "This username is already taken");
                        return View(viewModel);
                    }
                    user.Username = viewModel.Username;
                }

                if (user.Email != viewModel.Email)
                {
                    if (_context.User.Any(x => x.Email == viewModel.Email))
                    {
                        ModelState.AddModelError("Email", "This email is already taken");
                        return View(viewModel);
                    }
                    user.Email = viewModel.Email;
                }

                if (!string.IsNullOrEmpty(viewModel.UserNewPassword) && !string.IsNullOrEmpty(viewModel.UserNewPassword))
                {
                    byte[] passwordHash, passwordSalt;
                    AuthenticationHelper.CreatePasswordHash(viewModel.UserNewPassword, out passwordHash, out passwordSalt);
                    user.PasswordHash = passwordHash;
                    user.PasswordSalt = passwordSalt;
                }

                await _context.SaveChangesAsync();

                if (appSettings != null && !string.IsNullOrEmpty(appSettings.HeaderImages))
                    appSettings.HeaderImages.Split(",").ToList().ForEach(a => Helpers.FileHelper.moveCacheToImages(a));
            }
            return RedirectToAction(nameof(Index));
        }
    }
}
