using System;
using System.Collections.Generic;
using System.IO;
using System.Linq;
using System.Threading.Tasks;
using Microsoft.AspNetCore.Http;
using Microsoft.AspNetCore.Mvc;
using RealEstate.Helpers;

namespace RealEstate.Controllers
{
    [Route("[controller]")]
    public class UploadController : ControllerBase
    {
        [HttpGet("Image")]
        public IActionResult Get(string load)
        {
            if (FileHelper.checkImageFile(load))
            {
                return Redirect("~/UploadFiles/Images/" + load);
            }
            else
            {
                return Redirect("~/UploadFiles/Caches/" + load);
            }
        }

        [HttpPost("Image")]
        public async Task<IActionResult> Post(IFormFile filepond)
        {
            var fileName = Guid.NewGuid().ToString() + Path.GetExtension(filepond.FileName);
            var filePath = Path.Combine(Directory.GetCurrentDirectory(), @"UploadFiles\Caches", fileName);

            using (var stream = System.IO.File.Create(filePath))
            {
                await filepond.CopyToAsync(stream);
            }

            return Ok(fileName);
        }

        [HttpDelete("Image")]
        public async Task<IActionResult> Delete()
        {
            using (var reader = new StreamReader(Request.Body))
            {
                var fileName = await reader.ReadToEndAsync();
                var filePath = Path.Combine(Directory.GetCurrentDirectory(), @"UploadFiles\Caches", fileName);
                System.IO.File.Delete(filePath);
            }
            return Ok();
        }
    }
}