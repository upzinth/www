using System;
using System.Collections.Generic;
using System.Diagnostics;
using System.Linq;
using System.Threading.Tasks;
using Microsoft.AspNetCore.Authentication.Cookies;
using Microsoft.AspNetCore.Authentication.JwtBearer;
using Microsoft.AspNetCore.Authorization;
using Microsoft.AspNetCore.Mvc;
using Microsoft.EntityFrameworkCore;
using Microsoft.Extensions.Logging;
using RealEstate.Entities;
using RealEstate.Models;
using RealEstate.ViewModels;

namespace RealEstate.Controllers
{
    [Authorize(Roles = "Admin,Agent", AuthenticationSchemes = CookieAuthenticationDefaults.AuthenticationScheme)]
    public class HomeController : BaseController
    {
        private readonly RealEstateContext _context;

        public HomeController(RealEstateContext context)
        {
            _context = context;
        }

        public IActionResult Index()
        {
            var groupedQuery = from pl in _context.PropertyLikes
                               join p in _context.Property on pl.PropertyId equals p.Id
                               where p.UserId == UserId
                               group pl by pl.PropertyId into g
                               orderby g.Key descending
                               select new
                               {
                                   PropertyId = g.Key,
                                   Count = g.Count()
                               };

            var listQuery = from g in groupedQuery.Take(10)
                            join p in _context.Property.Include(a => a.City) on g.PropertyId equals p.Id
                            orderby g.Count descending
                            select new HomeLikedPropertiesModel
                            {
                                Property = p,
                                Count = g.Count
                            };

            var result = listQuery.ToList();

            return View(new HomeViewModel
            {
                LikedProperties = result
            });
        }


        [ResponseCache(Duration = 0, Location = ResponseCacheLocation.None, NoStore = true)]
        public IActionResult Error()
        {
            return View(new ErrorViewModel { RequestId = Activity.Current?.Id ?? HttpContext.TraceIdentifier });
        }
    }
}
