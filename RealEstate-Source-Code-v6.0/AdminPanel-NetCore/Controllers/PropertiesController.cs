using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;
using Microsoft.AspNetCore.Authentication.Cookies;
using Microsoft.AspNetCore.Authorization;
using Microsoft.AspNetCore.Mvc;
using Microsoft.AspNetCore.Mvc.Rendering;
using Microsoft.EntityFrameworkCore;
using RealEstate.Entities;
using RealEstate.Helpers;

namespace RealEstate.Controllers
{
    [Authorize(Roles = "Admin,Agent", AuthenticationSchemes = CookieAuthenticationDefaults.AuthenticationScheme)]
    public class PropertiesController : BaseController
    {
        private readonly RealEstateContext _context;

        public PropertiesController(RealEstateContext context)
        {
            _context = context;
        }

        // GET: Properties
        public async Task<IActionResult> Index()
        {
            var realEstateContext = _context.Property.Include(a => a.City).Include(a => a.PropertyCategory).Include(a => a.PropertyType).Include(a => a.User)
                .Where(a => a.UserId == UserId);
            return View(await realEstateContext.ToListAsync());
        }

        // GET: Properties/Create
        public IActionResult Create()
        {
            ViewData["CityId"] = new SelectList(_context.City, "Id", "Name");
            ViewData["PropertyCategoryId"] = new SelectList(_context.PropertyCategory, "Id", "Name");
            ViewData["PropertyTypeId"] = new SelectList(_context.PropertyType, "Id", "Name");
            ViewData["UserId"] = new SelectList(_context.User.Select(a => new { a.Id, FullName = a.FirstName + " " + a.LastName }), "Id", "FullName", UserId);
            return View();
        }

        // POST: Properties/Create
        // To protect from overposting attacks, please enable the specific properties you want to bind to, for 
        // more details see http://go.microsoft.com/fwlink/?LinkId=317598.
        [HttpPost]
        [ValidateAntiForgeryToken]
        public async Task<IActionResult> Create(Property model)
        {
            if (ModelState.IsValid)
            {
                if (!User.IsInRole("Admin"))
                {
                    model.UserId = UserId;
                }
                _context.Add(model);
                await _context.SaveChangesAsync();
                model.ImageNames.Split(",").ToList().ForEach(a => FileHelper.moveCacheToImages(a));
                return RedirectToAction(nameof(Index));
            }
            ViewData["CityId"] = new SelectList(_context.City, "Id", "Name", model.CityId);
            ViewData["PropertyCategoryId"] = new SelectList(_context.PropertyCategory, "Id", "Name", model.PropertyCategoryId);
            ViewData["PropertyTypeId"] = new SelectList(_context.PropertyType, "Id", "Name", model.PropertyTypeId);
            ViewData["UserId"] = new SelectList(_context.User.Select(a => new { a.Id, FullName = a.FirstName + " " + a.LastName }), "Id", "FullName");
            return View(model);
        }

        // GET: Properties/Edit/5
        public async Task<IActionResult> Edit(int? id)
        {
            if (id == null)
            {
                return NotFound();
            }

            var model = await _context.Property.FindAsync(id);
            if (model == null)
            {
                return NotFound();
            }
            if (!User.IsInRole("Admin") && model.UserId != UserId)
            {
                return NotFound();
            }
            ViewData["CityId"] = new SelectList(_context.City, "Id", "Name", model.CityId);
            ViewData["PropertyCategoryId"] = new SelectList(_context.PropertyCategory, "Id", "Name", model.PropertyCategoryId);
            ViewData["PropertyTypeId"] = new SelectList(_context.PropertyType, "Id", "Name", model.PropertyTypeId);
            ViewData["UserId"] = new SelectList(_context.User.Select(a => new { a.Id, FullName = a.FirstName + " " + a.LastName }), "Id", "FullName");
            return View(model);
        }

        // POST: Properties/Edit/5
        // To protect from overposting attacks, please enable the specific properties you want to bind to, for 
        // more details see http://go.microsoft.com/fwlink/?LinkId=317598.
        [HttpPost]
        [ValidateAntiForgeryToken]
        public async Task<IActionResult> Edit(int id, Property model)
        {
            if (id != model.Id)
            {
                return NotFound();
            }

            if (ModelState.IsValid)
            {
                try
                {
                   
                    var entity = _context.Property.AsNoTracking().SingleOrDefault(a => a.Id == id);
                    var entityImagesName = entity.ImageNames.Split(",").ToList();
                    var modelImagesName = model.ImageNames.Split(",").ToList();
                   
                    if (!User.IsInRole("Admin") && entity.UserId != UserId)
                    {
                        return NotFound();
                    }

                    if (!User.IsInRole("Admin"))
                    {
                        model.UserId = UserId;
                    }
                    _context.Update(model);
                    await _context.SaveChangesAsync();

                    modelImagesName.ForEach(a => FileHelper.moveCacheToImages(a));
                    entityImagesName.ForEach(a =>
                    {
                        if (!modelImagesName.Contains(a))
                        {
                            FileHelper.removeImageFile(a);
                        }
                    });
                }
                catch (DbUpdateConcurrencyException)
                {
                    if (!PropertyExists(model.Id))
                    {
                        return NotFound();
                    }
                    else
                    {
                        throw;
                    }
                }
                return RedirectToAction(nameof(Index));
            }
            ViewData["CityId"] = new SelectList(_context.City, "Id", "Name", model.CityId);
            ViewData["PropertyCategoryId"] = new SelectList(_context.PropertyCategory, "Id", "Name", model.PropertyCategoryId);
            ViewData["PropertyTypeId"] = new SelectList(_context.PropertyType, "Id", "Name", model.PropertyTypeId);
            ViewData["UserId"] = new SelectList(_context.User.Select(a => new { a.Id, FullName = a.FirstName + " " + a.LastName }), "Id", "FullName");
            return View(model);
        }

        // GET: Properties/Delete/5
        public async Task<IActionResult> Delete(int? id)
        {
            if (id == null)
            {
                return NotFound();
            }

            var model = await _context.Property
                .Include(a => a.City)
                .Include(a => a.PropertyCategory)
                .Include(a => a.PropertyType)
                .Include(a => a.User)
                .FirstOrDefaultAsync(m => m.Id == id);
            if (model == null)
            {
                return NotFound();
            }
            if (!User.IsInRole("Admin") && model.UserId != UserId)
            {
                return NotFound();
            }
            return View(model);
        }

        // POST: Properties/Delete/5
        [HttpPost, ActionName("Delete")]
        [ValidateAntiForgeryToken]
        public async Task<IActionResult> DeleteConfirmed(int id)
        {
            var entity = await _context.Property.FindAsync(id);
            if (!User.IsInRole("Admin") && entity.UserId != UserId)
            {
                return NotFound();
            }
            _context.Property.Remove(entity);
            await _context.SaveChangesAsync();
            entity.ImageNames.Split(",").ToList().ForEach(a => FileHelper.removeImageFile(a));
            return RedirectToAction(nameof(Index));
        }

        private bool PropertyExists(int id)
        {
            return _context.Property.Any(e => e.Id == id);
        }
    }
}
