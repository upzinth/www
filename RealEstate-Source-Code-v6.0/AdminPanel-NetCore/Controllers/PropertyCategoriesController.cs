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

namespace RealEstate.Controllers
{
    [Authorize(Roles = "Admin", AuthenticationSchemes = CookieAuthenticationDefaults.AuthenticationScheme)]
    public class PropertyCategoriesController : Controller
    {
        private readonly RealEstateContext _context;

        public PropertyCategoriesController(RealEstateContext context)
        {
            _context = context;
        }

        // GET: PropertyCategories
        public async Task<IActionResult> Index()
        {
            return View(await _context.PropertyCategory.ToListAsync());
        }

        // GET: PropertyCategories/Details/5
        public async Task<IActionResult> Details(int? id)
        {
            if (id == null)
            {
                return NotFound();
            }

            var propertyCategory = await _context.PropertyCategory
                .FirstOrDefaultAsync(m => m.Id == id);
            if (propertyCategory == null)
            {
                return NotFound();
            }

            return View(propertyCategory);
        }

        // GET: PropertyCategories/Create
        public IActionResult Create()
        {
            return View();
        }

        // POST: PropertyCategories/Create
        // To protect from overposting attacks, please enable the specific properties you want to bind to, for 
        // more details see http://go.microsoft.com/fwlink/?LinkId=317598.
        [HttpPost]
        [ValidateAntiForgeryToken]
        public async Task<IActionResult> Create([Bind("Id,Name,CreatedDate")] PropertyCategory propertyCategory)
        {
            if (ModelState.IsValid)
            {
                propertyCategory.CreatedDate = DateTime.Now;
                _context.Add(propertyCategory);
                await _context.SaveChangesAsync();
                return RedirectToAction(nameof(Index));
            }
            return View(propertyCategory);
        }

        // GET: PropertyCategories/Edit/5
        public async Task<IActionResult> Edit(int? id)
        {
            if (id == null)
            {
                return NotFound();
            }

            var propertyCategory = await _context.PropertyCategory.FindAsync(id);
            if (propertyCategory == null)
            {
                return NotFound();
            }
            return View(propertyCategory);
        }

        // POST: PropertyCategories/Edit/5
        // To protect from overposting attacks, please enable the specific properties you want to bind to, for 
        // more details see http://go.microsoft.com/fwlink/?LinkId=317598.
        [HttpPost]
        [ValidateAntiForgeryToken]
        public async Task<IActionResult> Edit(int id, [Bind("Id,Name,CreatedDate")] PropertyCategory propertyCategory)
        {
            if (id != propertyCategory.Id)
            {
                return NotFound();
            }

            if (ModelState.IsValid)
            {
                try
                {
                    _context.Update(propertyCategory);
                    await _context.SaveChangesAsync();
                }
                catch (DbUpdateConcurrencyException)
                {
                    if (!PropertyCategoryExists(propertyCategory.Id))
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
            return View(propertyCategory);
        }

        // GET: PropertyCategories/Delete/5
        public async Task<IActionResult> Delete(int? id)
        {
            if (id == null)
            {
                return NotFound();
            }

            var propertyCategory = await _context.PropertyCategory
                .FirstOrDefaultAsync(m => m.Id == id);
            if (propertyCategory == null)
            {
                return NotFound();
            }

            return View(propertyCategory);
        }

        // POST: PropertyCategories/Delete/5
        [HttpPost, ActionName("Delete")]
        [ValidateAntiForgeryToken]
        public async Task<IActionResult> DeleteConfirmed(int id)
        {
            var propertyCategory = await _context.PropertyCategory.FindAsync(id);
            _context.PropertyCategory.Remove(propertyCategory);
            await _context.SaveChangesAsync();
            return RedirectToAction(nameof(Index));
        }

        private bool PropertyCategoryExists(int id)
        {
            return _context.PropertyCategory.Any(e => e.Id == id);
        }
    }
}
