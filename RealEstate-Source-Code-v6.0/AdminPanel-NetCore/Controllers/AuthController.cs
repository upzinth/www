using System;
using System.Collections.Generic;
using System.IdentityModel.Tokens.Jwt;
using System.Linq;
using System.Security.Claims;
using System.Text;
using System.Threading.Tasks;
using Microsoft.AspNetCore.Authorization;
using Microsoft.AspNetCore.Http;
using Microsoft.AspNetCore.Mvc;
using Microsoft.Extensions.Options;
using Microsoft.IdentityModel.Tokens;
using RealEstate.Entities;
using RealEstate.Helpers;
using RealEstate.Models;

namespace RealEstate.Controllers
{
    [Authorize]
    [Route("api/v1/auth")]
    [ApiController]
    public class AuthController : BaseController
    {
        private readonly RealEstateContext _context;
        private readonly Helpers.AppSettings _appSettings;

        public AuthController(RealEstateContext context, IOptions<Helpers.AppSettings> appSettings)
        {
            _context = context;
            _appSettings = appSettings.Value;
        }

        [AllowAnonymous]
        [HttpPost("login")]
        public IActionResult Authenticate(LoginRequestModel requestModel)
        {
            var user = _context.User.SingleOrDefault(x => x.Username == requestModel.Username);

            // check if username exists
            if (user == null)
                return Error("Username or password is incorrect");

            // check if password is correct
            if (!AuthenticationHelper.VerifyPasswordHash(requestModel.Password, user.PasswordHash, user.PasswordSalt))
                return Error("Username or password is incorrect");

            var tokenHandler = new JwtSecurityTokenHandler();
            var key = Encoding.ASCII.GetBytes(_appSettings.Secret);
            var tokenDescriptor = new SecurityTokenDescriptor
            {
                Subject = new ClaimsIdentity(new Claim[]
                {
                    new Claim(ClaimTypes.NameIdentifier, user.Id.ToString()),
                    new Claim(ClaimTypes.Name, user.FirstName.ToString()),
                    new Claim(ClaimTypes.Surname, user.LastName.ToString()),
                    new Claim(ClaimTypes.Role, user.IsAdmin ? "Admin" : user.IsAgent ? "Agent" : "User")
                }),
                Expires = DateTime.UtcNow.AddYears(1),
                SigningCredentials = new SigningCredentials(new SymmetricSecurityKey(key), SecurityAlgorithms.HmacSha256Signature)
            };

            var token = tokenHandler.CreateToken(tokenDescriptor);
            var tokenString = tokenHandler.WriteToken(token);

            // return basic user info (without password) and token to store client side
            return Ok(new
            {
                Token = tokenString,
                user
            });
        }

        [AllowAnonymous]
        [HttpPost("register")]
        public async Task<IActionResult> Create(RegisterRequestModel requestModel)
        {
            if (_context.User.Any(x => x.Username == requestModel.Username))
                return Error("Username \"" + requestModel.Username + "\" is already taken");

            if (_context.User.Any(x => x.Email == requestModel.Email))
                return Error("Email \"" + requestModel.Email + "\" is already taken");

            byte[] passwordHash, passwordSalt;
            AuthenticationHelper.CreatePasswordHash(requestModel.Password, out passwordHash, out passwordSalt);

            var user = new User
            {
                FirstName = requestModel.FirstName,
                LastName = requestModel.LastName,
                IsAdmin = false,
                CreatedDate = DateTime.Now,

                Email = requestModel.Email,
                Username = requestModel.Username,
                PasswordHash = passwordHash,
                PasswordSalt = passwordSalt
            };

            _context.User.Add(user);
            await _context.SaveChangesAsync();

            return Ok();
        }

    }
}