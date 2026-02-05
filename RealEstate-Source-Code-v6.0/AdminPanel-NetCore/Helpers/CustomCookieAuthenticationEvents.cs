using Microsoft.AspNetCore.Authentication;
using Microsoft.AspNetCore.Authentication.Cookies;
using RealEstate.Entities;
using System.Linq;
using System.Security.Claims;
using System.Threading.Tasks;

namespace RealEstate.Helpers
{
    public class CustomCookieAuthenticationEvents : CookieAuthenticationEvents
    {
        private RealEstateContext dbContext;

        public CustomCookieAuthenticationEvents(RealEstateContext dbContext)
        {
            this.dbContext = dbContext;
        }

        public override async Task ValidatePrincipal(CookieValidatePrincipalContext context)
        {
            var userPrincipal = context.Principal;
            var userId = userPrincipal.FindFirstValue(ClaimTypes.NameIdentifier);

            if (userId == null)
            {
                context.RejectPrincipal();
                await context.HttpContext.SignOutAsync(CookieAuthenticationDefaults.AuthenticationScheme);
            }

            var user = dbContext.User.FirstOrDefault(a => a.Id == int.Parse(userId));

            if (user == null)
            {
                context.RejectPrincipal();
                await context.HttpContext.SignOutAsync(
                    CookieAuthenticationDefaults.AuthenticationScheme);
            }
        }
    }
}
