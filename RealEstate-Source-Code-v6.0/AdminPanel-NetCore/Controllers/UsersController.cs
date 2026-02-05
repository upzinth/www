using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;
using Microsoft.AspNetCore.Authentication.Cookies;
using Microsoft.AspNetCore.Authorization;
using Microsoft.AspNetCore.Mvc;
using Microsoft.EntityFrameworkCore;
using RealEstate.Entities;
using RealEstate.Models;

namespace RealEstate.Controllers
{
    [Authorize(Roles = "Admin", AuthenticationSchemes = CookieAuthenticationDefaults.AuthenticationScheme)]
    public class UsersController : Controller
    {
        private readonly RealEstateContext _context;

        public UsersController(RealEstateContext context)
        {
            _context = context;
        }

        public IActionResult Index()
        {
            return View(_context.User);
        }

        // GET: Users/Edit/5
        public async Task<IActionResult> Edit(int? id)
        {
            if (id == null)
            {
                return NotFound();
            }

            var user = await _context.User.FindAsync(id);
            if (user == null)
            {
                return NotFound();
            }
            return View(user);
        }

        // POST: Users/Edit/5
        // To protect from overposting attacks, please enable the specific properties you want to bind to, for 
        // more details see http://go.microsoft.com/fwlink/?LinkId=317598.
        [HttpPost]
        [ValidateAntiForgeryToken]
        public async Task<IActionResult> Edit(int id, User requestModel)
        {
            if (id != requestModel.Id)
            {
                return NotFound();
            }

            if (!User.IsInRole("Admin"))
            {
                return Redirect(Url.Action("Index"));
            }

            var user = _context.User.FirstOrDefault(a => a.Id == id);
            user.FirstName = requestModel.FirstName;
            user.LastName = requestModel.LastName;
            user.PhoneNumber = requestModel.PhoneNumber;
            user.Address = requestModel.Address;
            user.Latitude = requestModel.Latitude;
            user.Longitude = requestModel.Longitude;

            if (user.Username != requestModel.Username)
            {
                if (_context.User.Any(x => x.Username == requestModel.Username))
                {
                    ModelState.AddModelError("Username", "This username is already taken");
                    return View(requestModel);
                }
                user.Username = requestModel.Username;
            }

            if (user.Email != requestModel.Email)
            {
                if (_context.User.Any(x => x.Email == requestModel.Email))
                {
                    ModelState.AddModelError("Email", "This email is already taken");
                    return View(requestModel);
                }
                user.Email = requestModel.Email;
            }

            await _context.SaveChangesAsync();

            return Redirect(Url.Action("Index"));
        }

        [HttpPost, ActionName("UpdateRoleForAdmin")]
        public IActionResult UpdateRoleForAdmin(UpdateRoleRequestModel model)
        {
            var user = _context.User.FirstOrDefault(a => a.Id == model.UserId);
            user.IsAdmin = model.IsChecked;
            _context.SaveChanges();
            return Ok();
        }

        [HttpPost, ActionName("UpdateRoleForAgent")]
        public IActionResult UpdateRoleForAgent(UpdateRoleRequestModel model)
        {
            var user = _context.User.FirstOrDefault(a => a.Id == model.UserId);
            user.IsAgent = model.IsChecked;
            _context.SaveChanges();
            return Ok();
        }
    }
}