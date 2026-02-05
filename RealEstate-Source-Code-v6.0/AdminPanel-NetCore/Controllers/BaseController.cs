using System;
using System.Collections.Generic;
using System.Linq;
using System.Security.Claims;
using System.Threading.Tasks;
using Microsoft.AspNetCore.Mvc;

namespace RealEstate.Controllers
{
    public class BaseController : Controller
    {
        public int UserId
        {
            get
            {
                if (string.IsNullOrEmpty(User.FindFirstValue(ClaimTypes.NameIdentifier))) return -1;
                return int.Parse(User.FindFirst(ClaimTypes.NameIdentifier).Value);
            }
        }

        public IActionResult Error(string errorMessage)
        {
            return Ok(new
            {
                error = new
                {
                    message = errorMessage
                }
            });
        }
    }
}