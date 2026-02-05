using System;
using System.Collections.Generic;
using System.IO;
using System.Linq;
using System.Threading.Tasks;

namespace RealEstate.Helpers
{
    public static class FileHelper
    {
        public static bool checkCacheFile(string imageName)
        {
            var path = Path.Combine(Directory.GetCurrentDirectory(), "UploadFiles/Caches", imageName);
            return File.Exists(path);
        }

        public static bool checkImageFile(string imageName)
        {
            var path = Path.Combine(Directory.GetCurrentDirectory(), "UploadFiles/Images", imageName);
            return File.Exists(path);
        }
        public static void moveCacheToImages(string imageName)
        {
            var source = Path.Combine(Directory.GetCurrentDirectory(), "UploadFiles/Caches", imageName);
            var dest = Path.Combine(Directory.GetCurrentDirectory(), "UploadFiles/Images", imageName);
            if (File.Exists(source))
            {
                File.Move(source, dest);
            }
        }

        public static void removeImageFile(string imageName)
        {
            var path = Path.Combine(Directory.GetCurrentDirectory(), "UploadFiles/Images", imageName);
            if (File.Exists(path))
            {
                File.Delete(path);
            }
        }
    }
}
